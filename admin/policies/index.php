<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy List</title>
    <style>
        body {
            min-height: 100vh;
            background-color: mintgreen;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
        }
        .card {
            width: 82vw;
            height: 90vh;
            background-color: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(7px);
            box-shadow: 0 .4rem .8rem rgba(0, 0, 0, 0.3);
            border-radius: .8rem;
            overflow: hidden;
        }
        .card-header {
            width: 100%;
            height: 10%;
            background-color: rgba(255, 255, 255, 0.4);
            padding: .8rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-header .card-title {
            color: darkgreen;
            font-size: 1.5rem;
        }
        .card-header .card-tools {
            display: flex;
            align-items: center;
        }
        .btn-primary {
            background-color: red;
            border: none;
            color: white;
            padding: .5rem 1rem;
            border-radius: .5rem;
            cursor: pointer;
            transition: background-color .2s;
        }
        .btn-primary:hover {
            background-color: darkred;
        }
        .card-body {
            padding: 1rem;
            overflow-y: auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table thead th {
            background-color: #d5d1defe;
            cursor: pointer;
            text-transform: capitalize;
            color: darkgreen;
            padding: 1rem;
            position: sticky;
            top: 0;
        }
        .table tbody tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }
        .table th, .table td {
            padding: 1rem;
            text-align: left;
        }
        .status {
            padding: .4rem 0;
            border-radius: 2rem;
            text-align: center;
        }
        .status.active {
            background-color: #86e49d;
            color: #006b21;
        }
        .status.inactive {
            background-color: #d893a3;
            color: #b30021;
        }
    </style>
</head>
<body>
<div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-header">
        <h3 class="card-title">List of Policies</h3>
        <?php if($_settings->userdata('type') == 1): ?>
            <div class="card-tools">
                <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span> Add New Policy</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-bordered table-hover table-striped">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="25%">
                    <col width="20%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                <tr class="bg-gradient-primary text-light">
                    <th>#</th>
                    <th>Date Created</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Cost/Duration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $qry = $conn->query("SELECT p.*,c.name as category from `policy_list` p inner join category_list c on p.category_id = c.id where p.delete_flag = 0 order by c.`name` asc, p.name asc ");
                while($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td class=""><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                        <td class=""><p class="m-0 truncate-1"><?php echo $row['code'] ?></p></td>
                        <td class=""><p class="m-0 truncate-1"><?php echo $row['category']." - ".$row['name'] ?></p></td>
                        <td class="text-right"><?= format_num($row['cost'])."/".format_num($row['duration']).' year(s)' ?></td>
                        <td class="text-center">
                            <?php
                            switch ($row['status']){
                                case 1:
                                    echo '<span class="status active">Active</span>';
                                    break;
                                case 0:
                                    echo '<span class="status inactive">Inactive</span>';
                                    break;
                            }
                            ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Action
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item view_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                <?php if($_settings->userdata('type') == 1): ?>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item edit_data" href="javascript:void(0)" data-id ="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#create_new').click(function(){
            uni_modal("Add New Policy","policies/manage_policy.php",'large')
        })
        $('.view_data').click(function(){
            uni_modal("Policy Details","policies/view_policy.php?id="+$(this).attr('data-id'),'large')
        })
        $('.edit_data').click(function(){
            uni_modal("Update Policy Details","policies/manage_policy.php?id="+$(this).attr('data-id'),'large')
        })
        $('.delete_data').click(function(){
            _conf("Are you sure to delete this Policy permanently?","delete_policy",[$(this).attr('data-id')])
        })
        $('.table td, .table th').addClass('py-1 px-2 align-middle')
        $('.table').dataTable({
            columnDefs: [
                { orderable: false, targets: 5 }
            ],
        });
    })
    function delete_policy($id){
        start_loader();
        $.ajax({
            url:_base_url_+"classes/Master.php?f=delete_policy",
            method:"POST",
            data:{id: $id},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occurred.",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp== 'object' && resp.status == 'success'){
                    location.reload();
                }else{
                    alert_toast("An error occurred.",'error');
                    end_loader();
                }
            }
        })
    }
</script>
</body>
</html>