<?php
    require_once("../../../autoload/autoload.php");

    if(isset($_SESSION['id_admin']) && isset($_SESSION['role_id']))
    {
        $id = $_SESSION['id_admin'] ;
        $role_id= $_SESSION['role_id'];
    }

    checkLogin($id,$role_id);
    $permission = explode(',', $_SESSION['permission']);
    if (!in_array('edit-permission', $permission) && !in_array('all', $permission)) {
        redirect_to('admin/views/errors.php');
    }
    class viewEdit extends My_Model {}
    $viewRole = new viewEdit();
    if(testInputInt($_GET['id']))
    {
        $id = testInputInt($_GET['id']);

        $where = "id = ".$id;
        $data = $viewRole->fetchwhere('roles', $where);

        if (empty($data)) {
            # code...
            $_SESSION['error'] = "Vai trò không tồn tại (*).";
        }
    } else {
        echo "<script> window.location = 'index.php'; </script>";
    }

?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Chỉnh sửa</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right ">
                <button type="button" class="btn btn-round btn-danger" onclick="history.go(-1); return false;" style="float: right;" >Trở lại</button>
                <a href="index.php" class="btn btn-round btn-success" style="float: right;">Danh sách</a>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Chỉnh sửa</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12">
                            <?php
                            if (isset($_SESSION['error']))
                            {
                                warning($_SESSION['error']);
                                unset($_SESSION['error']);

                            }
                            ?>
                            <form name="roles" class="roles" id="roles" method="post" action="../../controller/RoleController.php?action=edit&id=<?php echo $data[0]['id']?>">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <label for="param_name" class="formLeft magin-left-30">Tên vai trò :<span class="req"> (*) </span></label>
                                        </td>
                                        <td>
                                            <input class="form-control col-md-7 col-xs-12" name="name" placeholder="Role" required="required" type="text" value="<?php echo $data[0]['name'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="param_name" class="formLeft magin-left-30">Mô tả :</label>
                                        </td>
                                        <td>
                                            <input class="form-control col-md-7 col-xs-12" name="description" placeholder="Description" type="text" value="<?php echo $data[0]['description'] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="param_name" class="formLeft magin-left-30">Quyền :<span class="req"> (*) </span></label>
                                        </td>
                                        <td>
                                            <select class="form-control col-md-12 col-xs-12 permission" name="permission[]" multiple="multiple">
                                                <?php foreach ($permissions as $key => $value): ?>
                                                    <option value="<?= $key ?>" <?php echo in_array($key, explode(',', $data[0]['permission'])) ? 'selected ="selected"' : '' ?> ><?= $value ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-info ">Chỉnh sửa</button>
                                            <button type="reset" class="btn btn-default">Hủy</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
