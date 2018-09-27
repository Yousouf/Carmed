var TableEditable = function () {

    var handleTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow, id) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[0] + '">';
            jqTds[1].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[1] + '">';
            jqTds[2].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[2] + '">';
            jqTds[3].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[3] + '">';
			jqTds[4].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
			jqTds[5].innerHTML = '<input type="text" class="form-control input-small" value="' + aData[4] + '">';
            jqTds[6].innerHTML = '<a class="edit btn btn-xs green" data-id="'+id+'" data-html="Save" href=""><i class="fa fa-save"></i> Valider</a>';
            jqTds[7].innerHTML = '<a class="cancel btn btn-xs red" data-id="'+id+'" href=""><i class="fa fa-times"></i> Annuler</a>';
        }

        function saveRow(oTable, nRow, id) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
			oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
			oTable.fnUpdate(jqInputs[4].value, nRow, 5, false);
            oTable.fnUpdate('<a class="edit btn btn-xs blue" data-id="'+id+'" href=""><i class="fa fa-edit"></i> Editer</a>', nRow, 6, false);
            oTable.fnUpdate('<a class="delete btn btn-xs red" data-id="'+id+'" href=""><i class="fa fa-times"></i> Supprimer</a>', nRow, 7, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow, id) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
			oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
			oTable.fnUpdate(jqInputs[4].value, nRow, 5, false);
            oTable.fnUpdate('<a class="edit btn btn-xs blue" data-id="'+id+'" href=""><i class="fa fa-edit"></i> Editer</a>', nRow, 6, false);
            oTable.fnDraw();
        }

        var table = $('#sample_editable');

        var oTable = table.dataTable({

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "language": {
				"metronicGroupActions": "_TOTAL_ element(s) selectonné(s)",
                "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
                "lengthMenu": "Nombre d'element par page: _MENU_",
                        "info": "_TOTAL_  Element(s) Trouvé(s)",
                        "infoEmpty": "Aucun element(s) trouvé(s)",
                        "emptyTable": "Tableau vide",
                        "zeroRecords": "Aucun element(s) trouvé(s)",
                        "paginate": {
                            "previous": "Precident",
                            "next": "Suivant",
                            "last": "Derniere",
                            "first": "Premiere",
                            "page": "Page",
                            "pageOf": "De"
                        }
            },
            "columnDefs": [{ // set default column settings
                'orderable': true,
                'targets': [0,1,2,3,4]
            }, {
                "searchable": true,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_wrapper");

        tableWrapper.find(".dataTables_length select").select2({
            showSearchInput: true //hide search box with special css class
        }); // initialize select2 dropdown

        var nEditing = null;
        var nNew = false;

        $('#sample_editable_new').click(function (e) {
            e.preventDefault();

            if (nNew && nEditing) {
                if (confirm("Previose row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;

                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;
                    
                    return;
                }
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '','','']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow,0);
            nEditing = nRow;
            nNew = true;
        });

        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }
            var nRow = $(this).parents('tr')[0];
            $.ajax({ // define ajax settings
					"url": "/admin/fabrication/products/delete", // ajax URL
					"type": "POST", // request type
					"data":{
						id: $(this).data('id')
					},
					success: function(data){
						oTable.fnDeleteRow(nRow);
					}
            })
        });

        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();

            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow, $(this).data('id'));
                nEditing = nRow;
            } else if (nEditing == nRow && $(this).data('html') == "Save") {
                /* Editing this row and want to save it */
                var jqInputs = $('input', nRow)
                $.ajax({ // define ajax settings
                        "url": "/admin/fabrication/products/save", // ajax URL
                        "type": "POST", // request type
                        "data":{
                            id:$(this).data('id'),
							name:jqInputs[0].value,
							reference:jqInputs[1].value,
							price:jqInputs[2].value,
							tax:jqInputs[3].value,
							type:jqInputs[4].value,
							unit:jqInputs[5].value
                        },
						success: function(data){
							saveRow(oTable, nEditing, data);
							nEditing = null;
						}
                })
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow, $(this).data('id'));
                nEditing = nRow;
            }
        });
    }

    return {

        //main function to initiate the module
        init: function () {
            handleTable();
        }
    };


}();