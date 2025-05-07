            <!-- Footer -->
            <footer class="sticky-footer bg-gradient-light mt-4">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span><img width="140px" src="/themes/sb-admin-2-gh-pages/img/compaynet_logo.png" alt=""> 2025</span>
                    </div>
                    <div class="text-center my-2">
                        <span>Contact Us: <a href="mailto:administration@compaynet.com" class="href">administration@compaynet.com</a></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo site_url('logout');?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
    <!-- Bootstrap popper.min.js -->
    
    <!-- Bootstrap core JavaScript-->
    <script src="/themes/sb-admin-2-gh-pages/vendor/jquery/jquery.min.js"></script>
    <script src="/themes/sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/themes/sb-admin-2-gh-pages/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/themes/sb-admin-2-gh-pages/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/themes/sb-admin-2-gh-pages/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="/themes/sb-admin-2-gh-pages/js/demo/chart-area-demo.js"></script>
    <script src="/themes/sb-admin-2-gh-pages/js/demo/chart-pie-demo.js"></script>
    <?php if(($active_sidebar == 'factoring' || $active_sidebar == 'dashboard' || $active_sidebar == 'user') && ($views_page == 'index')):?>
    <!-- Page level plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
    <?php endif;?>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
    <!-- tooltip -->
    <script>
    $(function () {
        $(".se-pre-con").delay(1000).fadeOut("slow");

        <?php if($views_page != 'index'):?>
            $('[data-toggle="tooltip"]').tooltip();
        <?php endif;?>

        $("form").submit(function(){
            $(".se-pre-con").fadeIn(100);
        });

        if ($("#card-message").length > 0)
        {
            $("#card-message").delay(8000).fadeOut('6000');
        }

        // start Tom-Select2
        if($(".tom-select-dropdown").length > 0)
        {
            new TomSelect(".tom-select-dropdown",{
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }

        if($(".tom-select-dropdown-a").length > 0)
        {
            new TomSelect(".tom-select-dropdown-a",{
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }

        if($(".tom-select-dropdown-b").length > 0)
        {
            new TomSelect(".tom-select-dropdown-b",{
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }

        if($(".tom-select-dropdown-c").length > 0)
        {
            new TomSelect(".tom-select-dropdown-c",{
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }

        if($(".tom-select-dropdown-d").length > 0)
        {
            new TomSelect(".tom-select-dropdown-d",{
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        }
        // end Tom-Select2
    });

    $('.td-href').click(function(){
        alert('test');
        $(".se-pre-con").fadeIn(100);
    });

    $('.collapse-item').click(function(){
        $(".se-pre-con").fadeIn(100);
    });

    $('.sidebar-brand-text').click(function(){
        $(".se-pre-con").fadeIn(100);
    });

    $('a.btn').click(function(){
        $(".se-pre-con").fadeIn(100);
    });

    function compute_items()
    {

        const netPricePerItemCents = parseFloat(document.getElementById("net_price_per_item_cents").value) || 0;
        const quantity = parseFloat(document.getElementById("quantity").value) || 0;
        const itemTaxCents = parseFloat(document.getElementById("item_tax_cents").value) || 0;
        const total = (netPricePerItemCents * quantity) + itemTaxCents;
        document.getElementById("net_price_cents").value = total.toFixed(2);
        return true;

    }
    // if index page
    <?php if(($active_sidebar == 'factoring' || $active_sidebar == 'dashboard') && ($views_page == 'index')):?>
    // DataTable
    // id, sellers.name, buyers.name, net_term, currency, status, created_at
    new DataTable('#factoring-lists', {
        ajax: '<?php echo base_url('/factoring/lists');?>',
        layout: {
            topStart: {
                buttons: ['copy', 'excel', 'pdf', 'print']
            }
        },
        columns: [
            { data: 'external_reference_id' },
            { data: 'seller_name' },
            { data: 'buyer_name' },
            { data: 'gross_amount' },
            { data: 'currency' },
            { data: 'net_term' },
            { data: 'status' },
            { data: 'created_at' }
        ],
        // add href in column 0
        "columnDefs": [
          { 
            // targets column is 0
             targets: 0,
             render : function(data, type, row, meta){
                if(type === 'display'){
                   return $('<a class="td-href">')
                      .attr('href', '/factoring/edit/' + row.id)
                      .text(data)
                      .wrap('<div></div>')
                      .parent()
                      .html();

                } else {
                   return data;
                }
             }
          } 
       ]
    });
    <?php endif;?>
    <?php if(($active_sidebar == 'user') && ($views_page == 'index')):?>
    // DataTable
    // id, sellers.name, buyers.name, net_term, currency, status, created_at
    new DataTable('#user-lists', {
        ajax: '<?php echo base_url('/user/lists');?>',
        layout: {
            topStart: {
                buttons: ['copy', 'excel', 'print']
            }
        },
        columns: [
            { data: 'id' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'seller_name' },
            { data: 'buyer_name' },
            { data: 'email' },
        ],
        // add href in column 0
        "columnDefs": [
          { 
            // targets column is 0
             targets: 0,
             render : function(data, type, row, meta){
                if(type === 'display'){
                   return $('<a class="td-href">')
                      .attr('href', '/user/edit/' + row.id)
                      .text(data)
                      .wrap('<div></div>')
                      .parent()
                      .html();

                } else {
                   return data;
                }
             }
          } 
       ]
    });
    <?php endif;?>
    </script>