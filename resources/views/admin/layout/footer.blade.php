<!-- END theme-panel -->
<!-- BEGIN btn-scroll-top -->
<a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
<!-- END btn-scroll-top -->
</div>
<!-- END #app -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- ================== BEGIN core-js ================== -->
<script src="{{ asset('admin/assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/app.min.js') }}"></script>
<!-- ================== END core-js ================== -->

<!-- ================== BEGIN page-js ================== -->
<script src="{{ asset('admin/assets/plugins/jvectormap-next/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/jvectormap-content/world-mill.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('admin/assets/js/demo/dashboard.demo.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- ================== END page-js ================== -->

<script async src="https://www.googletagmanager.com/gtag/js?id=G-Y3Q0VGQKY3"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-Y3Q0VGQKY3');
</script>
<style>
.app-sidebar.show-left{
	left:0px;
	z-index: 999999;
}
.mobile_menuw{
	display:none;		
	cursor: pointer;
}
@media (max-width:767.98px){
.mobile_menuw{
	display:block;	
	font-size:24px;
	z-index: 999999;
	cursor: pointer;
}
.mobile_menuw i{
	cursor: pointer;
}
.menu-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.overlay_menu.showover {
    position: fixed;
    top: 0px;
    left: 0px;
    background: rgba(00, 00, 00, 0.5);
    width: 100%;
    height: 100%;
    z-index: 9999;
}
.app-header .brand .brand-logo{
	padding:0px;
	display:block !important;
}  
}
</style>
<script>
function closeMobileSidebar() {
	var app = document.querySelector(".app") || document.getElementById("app");
	var sidebar = document.querySelector(".app-sidebar") || document.getElementById("sidebar");
	var overlay = document.querySelector(".overlay_menu");
	if (app) app.classList.remove("app-sidebar-mobile-toggled");
	if (sidebar) sidebar.classList.remove("show-left");
	if (overlay) overlay.classList.remove("showover");
}

document.addEventListener("click", function(e) {
	if (e.target.closest(".mobile_menuw") || e.target.closest(".overlay_menu") || e.target.closest(".app-sidebar-mobile-backdrop")) {
		closeMobileSidebar();
	}
});

$(document).ready(function(){
	$(".menu-toggler").click(function(){
		$(".app-sidebar").toggleClass("show-left");
		$(".overlay_menu").toggleClass("showover");
	});
	$(document).on("click", ".mobile_menuw", function(e){
		e.preventDefault();
		closeMobileSidebar();
	});
	$(document).on("click", ".overlay_menu, .app-sidebar-mobile-backdrop", function(e){
		e.preventDefault();
		closeMobileSidebar();
	});
});
</script>

</body>



</html>