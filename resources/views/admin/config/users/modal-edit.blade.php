<div class="modal fade" id="mEditUser"  tabindex="-1" role="dialog" aria-labelledby="mEditUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" action="#" id="frmEdit">
                    @method('PUT')
                    <div class="form-body">

                        <h4 class="form-section">
                            <i class="ft-briefcase"></i> User Data
                        </h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txtFirstNameE">First Name</label>
                                    <input class="form-control border-primary" type="text" placeholder="First Name" id="txtFirstNameE" name="txtFirstNameE">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txtLastNameE">Last Name</label>
                                    <input class="form-control border-primary" type="text" placeholder="Last Name" id="txtLastNameE" name="txtLastNameE">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtEmailE">Email</label>
                            <input class="form-control border-primary" type="email" placeholder="Email" id="txtEmailE" name="txtEmailE">
                        </div>

                        <h4 class="form-section">
                            <i class="la la-key"></i> Credentials
                        </h4>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                      <div class="input-group" >
                                        <input class="form-control border-primary" required id="txtPasswordE" name="txtPasswordE" type="password" placeholder="Password">
                                        <span class="input-group-append" id="btnSeePass">
                                            <button class="btn btn-success" type="button" data-repeater-delete="">
                                                <i class="ft-eye-off"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <div class="generate-password mt-1">
                                        <button class="btn btn-outline-info btn-sm" type="submit" id="btnGenPass">Generate Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-danger" id="btnSave">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


