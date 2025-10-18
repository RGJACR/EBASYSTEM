    <!-- </div><footer class="main-footer text-center"><strong>© 2025 Sistema Multisucursal</strong></footer></div> -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// DataTables defaults in spanish
$.extend(true, $.fn.dataTable.defaults, {
    responsive: true,
    language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
        "infoFiltered": "(filtrado de _MAX_ registros)",
        "lengthMenu": "Mostrar _MENU_ registros",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": { "first": "Primero", "last": "Último", "next": "Siguiente", "previous": "Anterior" }
    }
});

$(function(){
    // initialize tables with class .dt-export (only if not initialized)
    $('table.dt-export').each(function(){
        if(!$.fn.DataTable.isDataTable(this)){
            $(this).DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend:'csvHtml5', text: 'Exportar CSV' },
                    { extend:'excelHtml5', text: 'Exportar Excel' },
                    { extend:'pdfHtml5', text: 'Exportar PDF' },
                    { extend:'print', text: 'Imprimir' }
                ],
                responsive: true
            });
        }
    });

    // delegated handlers - modals and buttons
    $(document).on('click', '.editStudentBtn', function(){
        var b = $(this);
        $('#stu_id').val(b.data('id'));
        $('#stu_nombre').val(b.data('nombre'));
        $('#stu_grado').val(b.data('grado'));
        $('#stu_edad').val(b.data('edad'));
        $('#stu_cel').val(b.data('cel'));
        $('#editStudentModal').modal('show');
    });

    $(document).on('click', '.editDocBtn', function(){
        var b = $(this);
        $('#doc_id').val(b.data('id'));
        $('#doc_nombre').val(b.data('nombre'));
        $('#doc_email').val(b.data('email'));
        $('#doc_cel').val(b.data('cel'));
        $('#editDocModal').modal('show');
    });

    $(document).on('click', '.editAdminUserBtn', function(){
        var b = $(this);
        $('#adm_id').val(b.data('id'));
        $('#adm_nombre').val(b.data('nombre'));
        $('#adm_email').val(b.data('email'));
        $('#adm_rol').val(b.data('rol'));
        $('#adm_inst').val(b.data('inst'));
        $('#editAdminUserModal').modal('show');
    });

    $(document).on('click', '.evaluateDocBtn, .evaluateAdminBtn', function(){
        var b = $(this);
        $('#eval_docente_id').val(b.data('id'));
        $('#eval_docente_name').val(b.data('nombre'));
        $('#evalModal').modal('show');
    });

    $(document).on('click', '.editNotaBtn', function(){
        var b = $(this);
        $('#nota_id').val(b.data('id'));
        $('#nota_area').val(b.data('area'));
        $('#nota_val').val(b.data('nota'));
        $('#nota_estudiante').val(b.data('estudiante'));
        $('#notaModal').modal('show');
    });

    // encuesta modal open
    $(document).on('click', '.encuestarBtn', function(){
        var b = $(this);
        $('#enc_est_id').val(b.data('id'));
        $('#enc_est_name').val(b.data('nombre'));
        $('#enc_est_grado').val(b.data('grado'));
        $('#enc_est_cel').val(b.data('cel'));
        $('#enc_est_edad').val(b.data('edad'));
        $('#encModal').modal('show');
    });

    // swal map for quick alerts
    const params = new URLSearchParams(window.location.search);
    if(params.has('swal')){
        const s = params.get('swal');
        const map = {
            'profile_updated': ['Listo','Perfil actualizado','success'],
            'csv_uploaded': ['Listo','CSV cargado','success'],
            'student_added': ['Listo','Estudiante agregado','success'],
            'student_edited': ['Listo','Estudiante editado','success'],
            'teacher_created': ['Listo','Docente creado','success'],
            'teacher_exists': ['Error','El email ya existe','error'],
            'teacher_invalid': ['Error','Email inválido','error'],
            'teacher_edited': ['Listo','Docente editado','success'],
            'file_uploaded': ['Listo','Archivo subido','success'],
            'survey_saved': ['Listo','Encuesta guardada','success'],
            'survey_student_invalid': ['Error','Estudiante inválido o fuera de la II.EE','error'],
            'nota_saved': ['Listo','Nota guardada','success'],
            'evaluation_saved': ['Listo','Evaluación guardada','success'],
            'docente_status_changed': ['Listo','Estado del docente actualizado','success'],
            'document_state_changed': ['Listo','Estado del documento actualizado','success'],
            'user_baja': ['Acceso denegado','Usuario dado de baja','error']
        };
        if(map[s]){ const m=map[s]; setTimeout(()=>{ Swal.fire(m[0], m[1], m[2] || 'info'); }, 250); }
    }
});
</script></body></html>