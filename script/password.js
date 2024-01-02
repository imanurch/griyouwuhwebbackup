// login, add user modal
function ikon() {
  var e = document.getElementById("password-input");
  if (e.type === "password") {
    e.type = "text";
    document.getElementById("eyeon").style.display = "block";
    document.getElementById("eyeoff").style.display = "none";
    document.getElementById("eye").style.display = "none";
  } else {
    e.type = "password";
    document.getElementById("eyeon").style.display = "none";
    document.getElementById("eyeoff").style.display = "block";
    document.getElementById("eye").style.display = "none";
  }
}

// verif edit modal
function ikonverif() {
  var e = document.getElementById("password-input-verif");
  if (e.type === "password") {
    e.type = "text";
    document.getElementById("eyeon-verif").style.display = "block";
    document.getElementById("eyeoff-verif").style.display = "none";
    document.getElementById("eye-verif").style.display = "none";
  } else {
    e.type = "password";
    document.getElementById("eyeon-verif").style.display = "none";
    document.getElementById("eyeoff-verif").style.display = "block";
    document.getElementById("eye-verif").style.display = "none";
  }
}

// verif edit ulang modal
function ikonverifu() {
  var e = document.getElementById("password-input-verifu");
  if (e.type === "password") {
    e.type = "text";
    document.getElementById("eyeon-verifu").style.display = "block";
    document.getElementById("eyeoff-verifu").style.display = "none";
    document.getElementById("eye-verifu").style.display = "none";
  } else {
    e.type = "password";
    document.getElementById("eyeon-verifu").style.display = "none";
    document.getElementById("eyeoff-verifu").style.display = "block";
    document.getElementById("eye-verifu").style.display = "none";
  }
}

// kode izin modal
function ikonizin() {
  var e = document.getElementById("password-input-izin");
  if (e.type === "password") {
    e.type = "text";
    document.getElementById("eyeon-izin").style.display = "block";
    document.getElementById("eyeoff-izin").style.display = "none";
    document.getElementById("eye-izin").style.display = "none";
  } else {
    e.type = "password";
    document.getElementById("eyeon-izin").style.display = "none";
    document.getElementById("eyeoff-izin").style.display = "block";
    document.getElementById("eye-izin").style.display = "none";
  }
}

// kode izin ulang modal
function ikonizinu() {
  var e = document.getElementById("password-input-izinu");
  if (e.type === "password") {
    e.type = "text";
    document.getElementById("eyeon-izinu").style.display = "block";
    document.getElementById("eyeoff-izinu").style.display = "none";
    document.getElementById("eye-izinu").style.display = "none";
  } else {
    e.type = "password";
    document.getElementById("eyeon-izinu").style.display = "none";
    document.getElementById("eyeoff-izinu").style.display = "block";
    document.getElementById("eye-izinu").style.display = "none";
  }
}

// edit user modal
function ikonedit() {
  var e = document.getElementById("password-input-edit");
  if (e.type === "password") {
    e.type = "text";
    document.getElementById("eyeon-edit").style.display = "block";
    document.getElementById("eyeoff-edit").style.display = "none";
    document.getElementById("eye-edit").style.display = "none";
  } else {
    e.type = "password";
    document.getElementById("eyeon-edit").style.display = "none";
    document.getElementById("eyeoff-edit").style.display = "block";
    document.getElementById("eye-edit").style.display = "none";
  }
}