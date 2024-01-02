new DataTable("#dtable-user", {
  dom: '<"border-bottom pb-3"<"d-md-flex justify-content-between px-tb"<"toolbar-user d-flex align-items-center">f>><"px-tb pt-2"<"table-responsive"rt>><"px-tb tb-flex justify-content-between"lp><"clear">',
  fnInitComplete: function () {
    $("div.toolbar-user").html("Daftar Pengguna Aplikasi Griyo Uwuh");
  },
  lengthMenu: [10, 25, 50, 75, 100],
  language: {
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya",
    },
    search: "",
    searchPlaceholder: "Cari Kata Kunci",
    lengthMenu: "Tampilan _MENU_ Baris",
  },
});

new DataTable("#dtablenotverif", {
  dom: '<"border-bottom pb-3"<"d-md-flex justify-content-between px-tb"<"toolbar-not d-flex align-items-center">f>><"px-tb pt-2"<"table-responsive"rt>><"px-tb tb-flex justify-content-between"lp><"clear">',
  fnInitComplete: function () {
    $("div.toolbar-not").html("Daftar Pelanggan Belum Diverifikasi");
  },
  lengthMenu: [10, 25, 50, 75, 100],
  language: {
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya",
    },
    search: "",
    searchPlaceholder: "Cari Kata Kunci",
    lengthMenu: "Tampilan _MENU_ Baris",
  },
});

new DataTable("#dtableverif", {
  dom: '<"border-bottom pb-3"<"d-md-flex justify-content-between px-tb"<"toolbar d-flex align-items-center">f>><"px-tb pt-2"<"table-responsive"rt>><"px-tb tb-flex justify-content-between"lp><"clear">',
  fnInitComplete: function () {
    $("div.toolbar").html("Daftar Pelanggan Sudah Diverifikasi");
  },
  lengthMenu: [10, 25, 50, 75, 100],
  language: {
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya",
    },
    search: "",
    searchPlaceholder: "Cari Kata Kunci",
    lengthMenu: "Tampilan _MENU_ Baris",
  },
});

new DataTable("#dtable-rank", {
  dom: '<"border-bottom pb-3"<"d-md-flex justify-content-between px-tb"<"toolbar-rank d-flex align-items-center">f>><"px-tb pt-2"<"table-responsive"rt>><"px-tb tb-flex justify-content-between"lp><"clear">',
  fnInitComplete: function () {
    $("div.toolbar-rank").html("Peringkat Pengguna Aplikasi Griyo Uwuh");
  },
  lengthMenu: [10, 25, 50, 75, 100],
  language: {
    paginate: {
      previous: "Sebelumnya",
      next: "Selanjutnya",
    },
    search: "",
    searchPlaceholder: "Cari Kata Kunci",
    lengthMenu: "Tampilan _MENU_ Baris",
  },
});
