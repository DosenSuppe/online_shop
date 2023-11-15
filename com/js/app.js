function addWishlist(productId) {
  const image = document.getElementById("wish-for-" + productId);

  if (image.getAttribute("src") == "src/img/wish_no.png") {
    image.setAttribute("src", "src/img/wish_yes.png");
  } else {
    image.setAttribute("src", "src/img/wish_no.png");
  }
}