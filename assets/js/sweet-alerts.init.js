document.getElementById("sa-warning").addEventListener("click", function () {
  Swal.fire({
    title: "Keluar Akun",
    text: "Yakin ingin keluar dari akun Admin Griyo Uwuh?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f34e4e",
    cancelButtonColor: "#51d28c",
    confirmButtonText: "Keluar",
    cancelButtonText: "Batal",
  }).then(function (e) {
    e.value((window.location = "logout"));
  });
});
