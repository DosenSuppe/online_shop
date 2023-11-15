document.addEventListener("DOMContentLoaded", function() {
    // Sample product data (replace with your actual data)
    const products = [
      { imgSrc: "src/img/product.jpg", name: "Product 1", description: "Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsumLorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit.", price: "19.99" },
      { imgSrc: "src/img/product2.jpg", name: "Product 2", description: "Short description.", price: "211234.99" },
      { imgSrc: "src/img/product2.jpg", name: "Product 2", description: "Short description.", price: "24.99" },
      { imgSrc: "src/img/product.jpg", name: "Product 1", description: "Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit.", price: "19.99" },
      { imgSrc: "src/img/product2.jpg", name: "Product 2", description: "Short description.", price: "24.99" },
      { imgSrc: "src/img/product2.jpg", name: "Product 2", description: "Short description.", price: "24.99" },
      { imgSrc: "src/img/product.jpg", name: "Product 1", description: "Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit.", price: "19.99" },
      { imgSrc: "src/img/product2.jpg", name: "Product 2", description: "Short description.", price: "24.99" },
      { imgSrc: "src/img/product2.jpg", name: "Product 2", description: "Short description.", price: "24.99" },
      // Add more products as needed
    ];
  
    const productContainer = document.getElementById("product-container");
  
    // Populate products
    products.forEach(product => {
      const productSection = document.createElement("section");
      productSection.classList.add("product");
  
      productSection.innerHTML = `
        <img src="${product.imgSrc}" alt="${product.name}">
        <form action="./com/php/action/PutInCard.php" method="GET" class="product-info">
          <h2>
              <input type="text" name="product" value="${product.name}" readonly>
          </h2>

          <p class="description">${product.description}</p>
          <div class="price-container">
            <input type="text" class="price" name="price" value="${product.price}" readonly>
            <span>€</span>
          </div>

          <input type="submit" value="Add to Cart">
        </form>
      `;
  
      productContainer.appendChild(productSection);
  
      // Truncate description if too long
      const descriptionElement = productSection.querySelector(".description");
      const maxLength = 150;

      if (descriptionElement.textContent.length > maxLength) {
        descriptionElement.textContent = descriptionElement.textContent.substring(0, maxLength).trim() + "...";
      }
    });
  });
  