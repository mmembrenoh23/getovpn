<div class="modal fade" id="mCreateUser"  tabindex="-1" role="dialog" aria-labelledby="mCreateUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" action="{{ route('users.store') }}" id="frmCreate">
                    <div class="form-body">

                        <h4 class="form-section">
                            <i class="ft-briefcase"></i> User Data
                        </h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txtFirstName">First Name</label>
                                    <input class="form-control border-primary" type="text" placeholder="First Name" id="txtFirstName" name="txtFirstName">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="txtLastName">Last Name</label>
                                    <input class="form-control border-primary" type="text" placeholder="Last Name" id="txtLastName" name="txtLastName">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtEmail">Email</label>
                            <input class="form-control border-primary" type="email" placeholder="Email" id="txtEmail" name="txtEmail">
                        </div>

                        <h4 class="form-section">
                            <i class="la la-key"></i> Credentials
                        </h4>

                        <div class="row">
                            <div class="col-6">
                                 <div class="form-group">
                                    <label>Username</label>
                                    <input class="form-control border-primary" id="txtUsername" name="txtUsername" type="text" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Password</label>
                                      <div class="input-group" >
                                        <input class="form-control border-primary" required id="txtPassword" name="txtPassword" type="password" placeholder="Password">
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


