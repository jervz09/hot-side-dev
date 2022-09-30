<style>
    #fp-img-main{
        width:calc(100%) !important;
        height:60vh;
    }
</style>
<div class="card h-100 d-flex flex-column">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Floor Plan</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="update_fp">Update Floor Plan</button>
        </div>
    </div>
    <div class="card-body">
        <div class="col-md-12">
            <img src="./uploads/floorplan.png?v=<?php echo time() ?>" alt="Floor Plan" id="fp-img-main" class="w-100">
        </div>
    </div>
</div>
