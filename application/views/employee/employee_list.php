<?php if($this->session->userdata('msg'))
    echo "<div class='alert alert-success alert-dismissable'>
               <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
                  &times;
               </button>
               <span>".$this->session->userdata('msg')."</span></div>";
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">

               <div class="page-header">
                    <h3> List of Employees 
                        <div class="pull-right">
                            <a href="<?= base_url(); ?>employees/add_employee"  class='btn btn-alert'><i class="glyphicon glyphicon-plus"></i> Add New </a>
                        </div>
                    </h3>
                </div>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <table class="display table table-bordered table-striped dataTable" id="example1">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>EMP NAME</th>
                            <th>EMAIL</th>
                            <th>CONTACT</th>
                            <th></th> 
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 1;
                        if (!empty($employees)){
                        foreach ($employees as $results) {
                        $id = $results->EMP_ID; ?>


                        <tr class='gradeX'>

                            <td class='center'><?= $i ?></td>

                            <td><?= $results->EMP_NAME ?></td>

                            <td><?= $results->EMP_EMAIL; ?></td>
                            <td><?= $results->EMP_CELL; ?></td>
                            <td>
                                <?php if ($My_Controller->editPermission == NULL) {
                                    ?>
                                    <a href='<?= base_url() ?>employees/edit_employee/<?= $results->EMP_ID ?>' 
                                       class='btn btn-default' <?php echo $My_Controller->editPermission; ?>><i
                                            class='fa fa-pencil-square-o'></i>
                                    </a>
                                <?php } else {
                                    echo "<span class='btn btn-danger'>No Access</span>";
                                } ?>

                                <a href='<?= base_url() ?>employees/employee_detail/<?= $results->EMP_ID ?>'
                                   class='btn btn-default'><i class='fa fa-file-text'></i></a>
                            </td>
                            <?php

                            $i++;
                            }
                            }


                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
    <!-- /.col -->
</div>
<!-- page end-->