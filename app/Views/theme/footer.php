<!-- Footer -->
<footer class="sticky-footer bg-white mt-4">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <img width="140px" src="/themes/sb-admin-2-gh-pages/img/compaynet_logo.png" alt=""> 2025</span>
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
    
    <!-- tooltip -->
    <script>
    $(function () {
        $(".se-pre-con").delay(500).fadeOut("slow");
        $('[data-toggle="tooltip"]').tooltip()
    })

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
        let net_price_per_item_cents = document.getElementById("net_price_per_item_cents").value;
        let quantity = document.getElementById("quantity").value;
        let item_tax_cents = document.getElementById("item_tax_cents").value;
        let total = (parseFloat(net_price_per_item_cents) * parseFloat(quantity)) + parseFloat(item_tax_cents);
        document.getElementById("net_price_cents").value = total;
    }
    </script>
</body>

</html>