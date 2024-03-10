window.jsPDF = window.jspdf.jsPDF;
function printTable() {
  var tableToPrint = document.querySelector(".data-table").cloneNode(true);
  var printContainer = document.createElement("div");
  printContainer.appendChild(tableToPrint);
  printContainer.style.display = "none";
  document.body.appendChild(printContainer);
  window.print();
  document.body.removeChild(printContainer);
}

function exportTable(format) {
  if (format === "pdf") {
    exportToPDF();
  } else if (format === "excel") {
    exportToExcel();
  } else {
    exportToCSV();
  }
}

function exportToPDF() {
  var element = document.getElementById("imformationTable");

  html2pdf(element, {
    margin: 10,
    filename: "information_data.pdf",
    image: { type: "png", quality: 0.95 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
  });
}

function exportToExcel() {
  var table = document.getElementById("imformationTable");
  var wb = XLSX.utils.table_to_book(table);
  XLSX.writeFile(wb, "information_data.xlsx");
}

function exportToCSV() {
  var table = document.getElementById("imformationTable");
  var rows = table.querySelectorAll("tr");
  var csv = [];
  for (var i = 0; i < rows.length; i++) {
    var row = [],
      cols = rows[i].querySelectorAll("td, th");
    for (var j = 0; j < cols.length; j++) {
      row.push(cols[j].innerText);
    }
    csv.push(row.join(","));
  }
  var csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
  var encodedUri = encodeURI(csvContent);
  var link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "information_data.csv");
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
