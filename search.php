<?php require_once 'include/header.php'?>

  <script>
    $(document).ready(function() {
      // Handle form submission
      $(".contact-form").submit(function(e) {
        e.preventDefault();
        var searchTerm = $("#name").val();
        searchProducts(searchTerm);
      });

      // Function to search products
      function searchProducts(keyword) {
        $.ajax({
          url: "product.json",
          dataType: "json",
          success: function(data) {
            var results = [];
            // Search in each category
            Object.keys(data).forEach(function(category) {
              if (category !== "ProductCategory") {
                data[category].forEach(function(product) {
                  // Check if keyword matches product ID or name
                  if (
                    product.id.toLowerCase().includes(keyword.toLowerCase()) ||
                    (product.productName && product.productName.toLowerCase().includes(keyword.toLowerCase()))
                  ) {
                    results.push(product);
                  }
                });
              }
            });
            // Display search results in a table
            displayResults(results);
          },
          error: function(error) {
            console.log("Error fetching product data:", error);
          }
        });
      }

      // Function to display search results in a table
      function displayResults(results) {
        $(".search-results").empty(); // Assuming you have a container for search results

        if (results.length > 0) {
          var table = $("<table>");
          table.append("<tr><th>ID</th><th>Product Name</th><th>Price</th></tr>");

          results.forEach(function(product) {
            var productName = product.bookName || product.productName;
            table.append("<tr><td>" + product.id + "</td><td>" + productName + "</td><td>$" + product.price + "</td></tr>");
          });

          $(".search-results").append(table);
        } else {
          $(".search-results").append("<p>No results found.</p>");
        }
      }
    });
  </script>
</head>
<body>
  <div class="container">
    <div class="left-column">
      <div class="section">
        <h2>Search Products</h2>
      </div>
      <form class="contact-form" action="javascript:void(0)">
        <input type="text" id="name" name="search" placeholder="Search....">
        <button type="submit" class="contactButton">Search</button>
      </form>
    </div>
    <div class="search-results"></div>
  </div>
  <?php require_once 'include/footer.php'?>

