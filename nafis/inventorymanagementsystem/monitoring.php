<!DOCTYPE html>
<html>
<head>
    <title>Real-Time Monitoring</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="styles.css">
    <script>
        let debounceTimer;

        function fetchData(searchTerm = '') {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_warehouse_data.php?search=" + searchTerm, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById("warehouseData").innerHTML = this.responseText;
                    highlightSearchTerm(searchTerm);  // Call to highlight search results
                }
            };
            xhr.send();
        }

        // Fetch data when the page loads or when the search form is submitted
        window.onload = function() {
            fetchData();  // Initial fetch without search term
        }

        // Search handler for the form
        function searchWarehouse() {
            clearTimeout(debounceTimer); // Clear any previous timeout
            const searchTerm = document.getElementById("searchInput").value;
            debounceTimer = setTimeout(() => {
                fetchData(searchTerm);
            }, 300);  // Wait for 300ms after the last keypress before triggering the search
        }

        // Highlight rows that match the search term
        function highlightSearchTerm(searchTerm) {
            const rows = document.querySelectorAll("#warehouseData tr");
            rows.forEach(row => {
                const warehouseName = row.querySelector("td:nth-child(2)"); // Assuming warehouse name is in the second column
                if (warehouseName && warehouseName.textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
                    row.classList.add("highlight");
                    // Scroll the row into view
                    row.scrollIntoView({ behavior: "smooth", block: "center" });
                } else {
                    row.classList.remove("highlight");
                }
            });
        }

        // Refresh every 5 seconds
        setInterval(() => {
            fetchData(document.getElementById("searchInput").value);  // Pass the current search term
        }, 5000);
    </script>
</head>
<body>
    <h2>Real-Time Monitoring</h2>

    <!-- Search Form -->
    <div style="text-align: center;">
        <input type="text" id="searchInput" placeholder="Search by Warehouse Name" onkeyup="searchWarehouse()">
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>Sensor ID</th>
                <th>Warehouse Name</th>
                <th>Location</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Temperature (°C)</th>
                <th>Humidity (%)</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody id="warehouseData">
            <!-- Data will load here automatically -->
        </tbody>
    </table>
</body>
</html>
