function affiche() {
  const password = document.querySelector("#pass");
  const eye = document.querySelector("#eye");
  if (password.type == "password") {
    // cas où la valeur du pwd est cachée
    password.type = "text";
    eye.src = "./public/medias/eye-slash.svg";
  } else {
    password.type = "password";
    eye.src = "./public/medias/eye.svg";
  }
}
