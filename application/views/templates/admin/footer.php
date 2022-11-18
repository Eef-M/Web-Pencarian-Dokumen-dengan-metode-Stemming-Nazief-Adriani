<!-- Footer Start -->
<div style="background-color: #242F9B;" class="p-4 footer">
    <!-- <div class="rounded-top p-4"> -->

    <!-- </div> -->
</div>
<!-- Footer End -->
</div>
<!-- Content End -->


<!-- Back to Top -->
<!-- <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div> -->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/chart/chart.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/easing/easing.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/waypoints/waypoints.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/tempusdominus/js/moment.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="<?= base_url('assets/admin/') ?>lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<!-- <script src="<?= base_url('assets/admin/') ?>js/main.js"></script> -->
<script src="<?= base_url('assets/admin/') ?>js/script.js"></script>
<script>
var menu_btn = document.querySelector("#tugel");
var sidebar = document.querySelector("#theside");
var container = document.querySelector("#my-container");
menu_btn.addEventListener("click", () => {
    sidebar.classList.toggle("active-nav");
    container.classList.toggle("active-cont");
});
</script>
</body>

</html>