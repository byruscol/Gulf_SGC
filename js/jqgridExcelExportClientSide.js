/*
	Autor : CMOP
	fecha: 22/04/2013
*/
;
(function($) {
    $.jgrid.extend({
        exportarExcelCliente: function(o) {
            var archivoExporta, hojaExcel;
            archivoExporta = {
                worksheets: [[]],
                creator: "Arcmop",
                created: new Date(),
                lastModifiedBy: "Arcmop",
                modified: new Date(),
                activeWorksheet: 0
            };
            hojaExcel = archivoExporta.worksheets[0];
            hojaExcel.name = o.nombre;

            var arrayCabeceras = new Array();
            arrayCabeceras = $(this).getDataIDs();
	    
            var dataFilaGrid = $(this).getRowData(arrayCabeceras[0]);
	    
	    var columnNames = $(this).jqGrid('getGridParam','colNames');
	    
	    var Headerrow = new Array();
            var ij = 0;
            for (var i in columnNames) {
                Headerrow[ij++] = columnNames[i];
            }
	    
            var nombreColumnas = new Array();
            var ii = 0;
            for (var i in dataFilaGrid) {
                nombreColumnas[ii++] = i;
            }
            //hojaExcel.push(nombreColumnas);
	    hojaExcel.push(Headerrow);
	    
            var dataFilaArchivo;
            for (i = 0; i < arrayCabeceras.length; i++) {
                dataFilaGrid = $(this).getRowData(arrayCabeceras[i]);
                dataFilaArchivo = new Array();
                for (j = 0; j < nombreColumnas.length; j++) {
                    dataFilaArchivo.push(dataFilaGrid[nombreColumnas[j]]);
                }
                hojaExcel.push(dataFilaArchivo);
            }
            return window.location = xlsx(archivoExporta).href();
        },
        exportarTextoCliente: function(o) {
            var arrayCabeceras = new Array();
            arrayCabeceras = $(this).getDataIDs();
            var dataFilaGrid = $(this).getRowData(arrayCabeceras[0]);
            var nombreColumnas = new Array();
            var ii = 0;
            var textoRpta = "";
            for (var i in dataFilaGrid) {
                nombreColumnas[ii++] = i;
                textoRpta = textoRpta + i + "\t";
            }
            textoRpta = textoRpta + "\n";
            for (i = 0; i < arrayCabeceras.length; i++) {
                dataFilaGrid = $(this).getRowData(arrayCabeceras[i]);
                for (j = 0; j < nombreColumnas.length; j++) {
                    textoRpta = textoRpta + dataFilaGrid[nombreColumnas[j]] + "\t";
                }
                textoRpta = textoRpta + "\n";
            }
            textoRpta = textoRpta + "\n";
            return textoRpta;
        }
    });
})(jQuery);