<?php require_once 'include/header.php'?>
<style>
    .btn{
        padding: 10px 20px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
    <div class="banner">
        <h2>Welcome to e-commerce company</h2>
        <p>Get the best products and best deals from here!</p>
        <button>Read More</button>
    </div>
    <div class="about">
        <img src="image/company2.jpg" alt="About Image" style="width: 400px;">
        <div class="about-text">
            <h2>About our Ecommerce Dream</h2>
            <p>The e-commerce company is a dynamic online platform that facilitates the buying and selling of goods and services over the internet.</p> 
            <p>It provides customers with a convenient and accessible marketplace to browse, select, and purchase products from the comfort of their homes. Leveraging digital transactions, secure payment gateways, and efficient logistics, e-commerce companies connect buyers and sellers globally, offering a diverse range of products. These platforms often employ sophisticated technologies such as AI and data analytics to enhance user experience, personalize recommendations, and streamline operations. With a focus on convenience, variety, and technology-driven solutions, e-commerce companies redefine the modern retail landscape.</p>
        </div>
    </div>
    <div class="container">
        <div class="left-column">
            <div class="section">
                <h2>Life at Quantic at Dream</h2>
                <a href="#" class="checkout-btn" data-category="Electronics1">Electronics 1</a>
                <a href="#" class="checkout-btn" data-category="Electronics2">Electronics 2</a>
                <a href="#" class="checkout-btn" data-category="Perfume">Perfume</a>
                <a href="#" class="checkout-btn" data-category="Book">Books</a>
                <button class="btn"><a href="search.php">Search</a></button>

                <br>
            </div>
        </div>

    </div>
    
    <div class="release-container">
        <table id="productTable">
            <thead>
                <tr id="tableHeader"></tr>
            </thead>
        </table>
    </div>
    <script>
    $(document).ready(function () {
        $(".checkout-btn").on("click", function (e) {
            e.preventDefault()
            var category = $(this).data("category");
            if(category == "Electronics1" || category == "Electronics2"){
                fetchElecData(category);

            }
            else{
                fetchProductData(category);

            }
        });

        function fetchElecData(category) {
            // Clear the existing table content
            $("#productTable").empty();

            // Load and parse XML data
            $.ajax({
            type: "GET",
            url: "electronics.xml", // Specify the correct path to your XML file
            dataType: "xml",
            success: function(xml) {
                // Iterate through the XML based on the selected category
                $(xml).find(category).each(function() {
                var id = $(this).find('id').text();
                var productName = $(this).find('ProductName').text();
                var price = $(this).find('Price').text();
                var brand = $(this).find('Brand').text();
                var os = $(this).find('OS').text();
                var cpu = $(this).find('CPU').text();
                var screenSize = $(this).find('ScreenSize').text();
                var memorySize = $(this).find('ComputerMemorySize').text();

                

                var row = "<tr><td>ID: " + id + "</td><td>Product: " + productName + "</td><td>Price: $" + price + "</td><td>Brand: " + brand + "</td><td>OS: " + os + "</td><td>CPU: " + cpu + "</td><td>Screen Size: " + screenSize + "</td><td>Memory Size: " + memorySize + "</td></tr>";
                $("#productTable").append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching XML data: " + error);
            }
            });
        }
        function fetchProductData(category) {
            $.ajax({
                url: 'product.json',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    displayProductTable(category, data);
                },
                error: function (error) {
                    console.error('Error fetching product data:', error);
                }
            });
        }

        function displayProductTable(category, data) {
            var table = $('#productTable');
            table.empty();

            // Create table headings based on the category
            var headings = '<tr>';
            Object.keys(data[category][0]).forEach(function (key) {
                headings += '<th>' + key + '</th>';
            });
            headings += '</tr>';
            table.append(headings);

            // Populate table rows with product data
            data[category].forEach(function (product) {
                var row = '<tr>';
                Object.keys(product).forEach(function (key) {
                    if (key === 'img') {
                        row += '<td><img src="' + product[key] + '" alt="Product Image" height="100"></td>';
                    } else {
                        row += '<td>' + product[key] + '</td>';
                    }
                });
                row += '</tr>';
                table.append(row);
            });
        }
    });
</script>
<?php require_once 'include/footer.php'?>

    

