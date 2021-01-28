 <!--  Editar -->
 <div class="modal fade" id="mEditar"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit <span class="filename"></span> Attribute</h4> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>                    
            </div>
            <div class="modal-body">
                 <form class="form">
                    <div class="form-body">

                        <div class="form-group">
                            <label for="txtTitle">Title</label>
                            <input class="form-control border-primary" type="text" placeholder="Title" id="txtTitle">
                        </div>

                        <div class="form-group">
                            <label for="txtOwner">Owner</label>
                            <input class="form-control border-primary" type="text" placeholder="Owner" id="txtOwner">
                        </div>                          

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger mr-1" data-dismiss="modal">
                            <i class="ft-x"></i> Cancel
                        </button>
               <button type="submit" class="btn btn-primary">
                            <i class="la la-check-square-o"></i> Save
                        </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
