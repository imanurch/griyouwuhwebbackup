document.onreadystatechange = function() {
    if (document.readyState !== "complete") {
      document.querySelector("#loader").style.visibility = "visible";
    } else {
      document.querySelector("#loader").style.display = "none";
    }
  };