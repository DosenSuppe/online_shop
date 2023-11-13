document.addEventListener("DOMContentLoaded", function() {
    // Sample product data (replace with your actual data)
    const products = [
      { imgSrc: "product.jpg", name: "Product 1", description: "Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit.", price: "19.99€" },
      { imgSrc: "product2.jpg", name: "Product 2", description: "Short description.", price: "24.99€" },
      { imgSrc: "product2.jpg", name: "Product 2", description: "Short description.", price: "24.99€" },
      { imgSrc: "product.jpg", name: "Product 1", description: "Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit.", price: "19.99€" },
      { imgSrc: "product2.jpg", name: "Product 2", description: "Short description.", price: "24.99€" },
      { imgSrc: "product2.jpg", name: "Product 2", description: "Short description.", price: "24.99€" },
      { imgSrc: "product.jpg", name: "Product 1", description: "Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum dolor sit amet, consectetur adipiscing elit.", price: "19.99€" },
      { imgSrc: "product2.jpg", name: "Product 2", description: "Short description.", price: "24.99€" },
      { imgSrc: "product2.jpg", name: "Product 2", description: "Short description.", price: "24.99€" },
      // Add more products as needed
    ];
  
    const productContainer = document.getElementById("product-container");
  
    // Populate products
    products.forEach(product => {
      const productSection = document.createElement("section");
      productSection.classList.add("product");
  
      productSection.innerHTML = `
        <img src="${product.imgSrc}" alt="${product.name}">
        <div class="product-info">
          <h2>${product.name}</h2>
          <p class="description">${product.description}</p>
          <span class="price">${product.price}</span>
          <button>Add to Cart</button>
        </div>
      `;
  
      productContainer.appendChild(productSection);
  
      // Truncate description if too long
      const descriptionElement = productSection.querySelector(".description");
      const maxLength = 100;

      if (descriptionElement.textContent.length > maxLength) {
        descriptionElement.textContent = descriptionElement.textContent.substring(0, maxLength).trim() + "...";
      }
    });
  });
  