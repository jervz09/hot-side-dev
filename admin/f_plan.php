<style>
    #fp-img-main{
        width:calc(100%) !important;
        height:60vh;
    }
</style>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Floor Plan</h1>
        <div class="card-tools align-middle">
            <button type="button" id="update_fp" class="btn btn-primary btn-sm btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-file-upload"></i>
                </span>
                <span class="text">Update Floor Plan</span>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="col-md-12">
            <img src="./uploads/floorplan.png?v=<?php echo time() ?>" alt="Floor Plan" id="fp-img-main" class="w-100">
        </div>
    </div>
</div>
