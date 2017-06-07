@include('header')
<!-- start: Content -->
<div id="content" class="span10">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="index.html">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li><a href="#">Tables</a></li>
    </ul>
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header">
                <h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Combined All Table</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Date registered</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/01/01</td>
                        <td class="center">Member</td>
                        <td class="center">
                            <span class="label label-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/02/01</td>
                        <td class="center">Staff</td>
                        <td class="center">
                            <span class="label label-important">Banned</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/02/01</td>
                        <td class="center">Admin</td>
                        <td class="center">
                            <span class="label">Inactive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/03/01</td>
                        <td class="center">Member</td>
                        <td class="center">
                            <span class="label label-warning">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/01/21</td>
                        <td class="center">Staff</td>
                        <td class="center">
                            <span class="label label-success">Active</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="pagination pagination-centered">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
        </div><!--/span-->
    </div><!--/row-->


    <div class="row-fluid sortable">
        <div class="box span6">
            <div class="box-header">
                <h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Bordered Table</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Date registered</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/01/01</td>
                        <td class="center">Member</td>
                        <td class="center">
                            <span class="label label-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/02/01</td>
                        <td class="center">Staff</td>
                        <td class="center">
                            <span class="label label-important">Banned</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/02/01</td>
                        <td class="center">Admin</td>
                        <td class="center">
                            <span class="label">Inactive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/03/01</td>
                        <td class="center">Member</td>
                        <td class="center">
                            <span class="label label-warning">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/01/21</td>
                        <td class="center">Staff</td>
                        <td class="center">
                            <span class="label label-success">Active</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="pagination pagination-centered">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
        </div><!--/span-->

        <div class="box span6">
            <div class="box-header">
                <h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Condensed Table</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Date registered</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/01/01</td>
                        <td class="center">Member</td>
                        <td class="center">
                            <span class="label label-success">Active</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/02/01</td>
                        <td class="center">Staff</td>
                        <td class="center">
                            <span class="label label-important">Banned</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/02/01</td>
                        <td class="center">Admin</td>
                        <td class="center">
                            <span class="label">Inactive</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/03/01</td>
                        <td class="center">Member</td>
                        <td class="center">
                            <span class="label label-warning">Pending</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Dennis Ji</td>
                        <td class="center">2012/01/21</td>
                        <td class="center">Staff</td>
                        <td class="center">
                            <span class="label label-success">Active</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="pagination pagination-centered">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
        </div><!--/span-->

    </div><!--/row-->




</div><!--/.fluid-container-->

<!-- end: Content -->
</div><!--/#content.span10-->
</div><!--/fluid-row-->

<div class="modal hide fade" id="myModal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Settings</h3>
    </div>
    <div class="modal-body">
        <p>Here settings can be configured...</p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Close</a>
        <a href="#" class="btn btn-primary">Save changes</a>
    </div>
</div>
<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <ul class="list-inline item-details">
            <li><a href="http://themifycloud.com">Admin templates</a></li>
            <li><a href="http://themescloud.org">Bootstrap themes</a></li>
        </ul>
    </div>
</div>
<div class="clearfix"></div>
@include('footer')