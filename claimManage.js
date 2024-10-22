// Load Google Charts
google.charts.load('current', {
    packages: ['corechart', 'bar']
});

// Claim Clearances Chart
google.charts.setOnLoadCallback(fetchDataAndDrawClearancesChart);

function fetchDataAndDrawClearancesChart() {
    const yearInput = document.getElementById('yearSelect');
    const selectedYear = yearInput.value;

    // Fetch data from the PHP script for Claim Clearances
    fetch('backend/claimDiagnostic.php?type=clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            year: selectedYear
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        const validatedData = data.map(item => Number(item)); // Convert all values to numbers
        if (validatedData.some(isNaN)) {
            console.error('Data contains invalid numbers:', validatedData);
            return;
        }
        drawClearancesChart(validatedData);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function drawClearancesChart(monthlyData) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    data.addColumn('number', 'Claims Cleared');

    data.addRows([
        ['Jan', monthlyData[0]],
        ['Feb', monthlyData[1]],
        ['Mar', monthlyData[2]],
        ['Apr', monthlyData[3]],
        ['May', monthlyData[4]],
        ['Jun', monthlyData[5]],
        ['Jul', monthlyData[6]],
        ['Aug', monthlyData[7]],
        ['Sep', monthlyData[8]],
        ['Oct', monthlyData[9]],
        ['Nov', monthlyData[10]],
        ['Dec', monthlyData[11]]
    ]);

    var options = {
        title: 'Claim Clearances Throughout the Year',
        hAxis: { title: 'Month' },
        vAxis: { title: 'Number of Claims Cleared', minValue: 0 },
        backgroundColor: 'transparent',
        colors: ['#FF204E'],
        chartArea: { width: '90%' },
        annotations: {
            alwaysOutside: true,
            textStyle: { fontSize: 12, color: '#00224D', auraColor: 'none' }
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);

    var totalCleared = monthlyData.reduce((acc, val) => acc + val, 0);
    document.getElementById('total_value').innerText = 'Yearly Claim Cleared: ' + totalCleared;
}

// Claim Pending Chart
google.charts.setOnLoadCallback(fetchDataAndDrawPendingChart);

function fetchDataAndDrawPendingChart() {
    const yearInput = document.getElementById('yearSelect1');
    const selectedYear = yearInput.value;

    // Fetch data from the PHP script for Claim Pending
    fetch('backend/claimDiagnostic.php?type=pending', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            year: selectedYear
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        const validatedData = data.map(item => Number(item)); // Convert all values to numbers
        if (validatedData.some(isNaN)) {
            console.error('Data contains invalid numbers:', validatedData);
            return;
        }
        drawPendingChart(validatedData);
    })
    .catch(error => console.error('Error fetching data:', error));
}

function drawPendingChart(monthlyData) {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    data.addColumn('number', 'Claims Pending');

    data.addRows([
        ['Jan', monthlyData[0]],
        ['Feb', monthlyData[1]],
        ['Mar', monthlyData[2]],
        ['Apr', monthlyData[3]],
        ['May', monthlyData[4]],
        ['Jun', monthlyData[5]],
        ['Jul', monthlyData[6]],
        ['Aug', monthlyData[7]],
        ['Sep', monthlyData[8]],
        ['Oct', monthlyData[9]],
        ['Nov', monthlyData[10]],
        ['Dec', monthlyData[11]]
    ]);

    var options = {
        title: 'Claim Pending Throughout the Year',
        hAxis: { title: 'Month' },
        vAxis: { title: 'Number of Claims Pending', minValue: 0 },
        backgroundColor: 'transparent',
        colors: ['#FF204E'],
        chartArea: { width: '90%' },
        annotations: {
            alwaysOutside: true,
            textStyle: { fontSize: 12, color: '#00224D', auraColor: 'none' }
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
    chart.draw(data, options);

    var totalPending = monthlyData.reduce((acc, val) => acc + val, 0);
    document.getElementById('total_value1').innerText = 'Yearly Claim Pending: ' + totalPending;
}

// Function to fetch the ready to stock count for a selected year
function fetchReadyToStock() {
    // Get the selected year from the input
    const yearInput = document.getElementById('yearSelect3');
    const selectedYear = yearInput.value;

    // Fetch data from the PHP script using POST
    fetch('backend/claimDiagnostic.php?type=readyToStock', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            year: selectedYear // Send the selected year to the PHP script
        })
    })
    .then(response => response.json()) // Parse the response as JSON
    .then(data => {
        if (typeof data.totalStock !== 'undefined') {
            document.getElementById('stockValue').innerText = data.totalStock + ' pcs'; // Update stock value
            // document.getElementById('stockValue').setAttribute('data-bs-title', `Year: ${selectedYear}, Total Stock: ${totalStockText}`);
        } else {
            console.error('Unexpected data format:', data);
        }
    })
    .catch(error => console.error('Error fetching stock data:', error));
}

function dealerDetails() {
    const selectedDealer = this.value;

    fetch('backend/claimDiagnostic.php?type=dealer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            uniqueId: selectedDealer
        })
    })
    .then(response => response.json())
    .then(data => {
        // Check if the necessary data exists
        if (data.totalClaimClear !== undefined && data.totalClaimPending !== undefined) {
            document.getElementById('totalClaimClear').innerText = 'Total claim Clear: ' + data.totalClaimClear;
            document.getElementById('totalClaimPending').innerText = 'Total claim Pending: ' + data.totalClaimPending;

            // Update battery quantities
            const batteryQtyList = document.getElementById('batteryQtyList');
            batteryQtyList.innerHTML = ''; // Clear existing list
            if (data.batteryQuantities && typeof data.batteryQuantities === 'object') {
                Object.entries(data.batteryQuantities).forEach(([batteryType, quantity]) => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${batteryType} : ${quantity}`;
                    batteryQtyList.appendChild(listItem);
                });
            }
        } else {
            console.error('Invalid response data:', data);
        }
    })
    .catch(error => console.error('Error fetching claim details:', error));
}
function dealerDetailsRange() {
    const startingDate = document.getElementById('startingDate').value;
    const endingDate = document.getElementById('endingDate').value;

    // Perform the fetch request, sending the date range as POST data
    fetch('backend/claimDiagnostic.php?type=dealerRange', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            startingDate: startingDate, // Send starting date
            endingDate: endingDate      // Send ending date
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.totalClaimClear !== undefined && data.totalClaimPending !== undefined) {
            document.getElementById('totalClaimClear').innerText = 'Total claim Clear: ' + data.totalClaimClear;
            document.getElementById('totalClaimPending').innerText = 'Total claim Pending: ' + data.totalClaimPending;

            // Update battery quantities
            const batteryQtyList = document.getElementById('batteryQtyList');
            batteryQtyList.innerHTML = ''; // Clear existing list
            if (data.batteryQuantities && typeof data.batteryQuantities === 'object') {
                Object.entries(data.batteryQuantities).forEach(([batteryType, quantity]) => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${batteryType} : ${quantity}`;
                    batteryQtyList.appendChild(listItem);
                });
            }
        } else {
            console.error('Invalid response data:', data);
        }
    })
    .catch(error => console.error('Error fetching claim details:', error));
}

// Add event listeners
document.getElementById('startingDate').addEventListener('change', dealerDetailsRange);
document.getElementById('endingDate').addEventListener('change', dealerDetailsRange);
document.getElementById('dealerSelect').addEventListener('change', dealerDetails);
document.getElementById('yearSelect3').addEventListener('input', fetchReadyToStock);
document.getElementById('yearSelect').addEventListener('input', fetchDataAndDrawClearancesChart);
document.getElementById('yearSelect1').addEventListener('input', fetchDataAndDrawPendingChart);
