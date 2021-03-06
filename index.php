<?php
require('conf.php');

$searchvalue = "";

if (isset($_REQUEST["inputsearch"])){
    $searchvalue = $_REQUEST["inputsearch"];
}

session_start();
if (empty($_SESSION["user"])){
    header("Location: login.php");
}
else
    $user = $_SESSION["user"];

if(isset($_REQUEST["Add"])) {
    $data = $yhendus->prepare("INSERT INTO taskid(tahtaeg, oppeaine, tooliik, task, user) VALUES (?,?,?,?,?)");
    $data->bind_param("ssssi", $_REQUEST["tahtaeg"], $_REQUEST["oppeaine"], $_REQUEST["tooliik"], $_REQUEST["task"], $user);
    $data->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
}

if(isset($_REQUEST["Delete"])) {
    $kask = $yhendus->prepare("DELETE FROM taskid WHERE id=?");
    $kask->bind_param("i", $_REQUEST["Delete"]);
    header("Location: $_SERVER[PHP_SELF]");
}

if(isset($_REQUEST["edit"])) {
    $kask = $yhendus->prepare("UPDATE taskid SET tahtaeg=?, oppeaine=?, tooliik=?, task=? WHERE id=?");
    $kask->bind_param("ssssi", $_REQUEST["tahtaeg"], $_REQUEST["oppeaine"], $_REQUEST["tooliik"], $_REQUEST["info"], $_REQUEST["idEdit"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>TODO-list</title>
</head>
<body>
<section class="vh-100">
    <div class="container  py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-15 col-xl-14">
                <div class="mask-custom">
                    <div class="card-body p-4 text-white" >
                        <p>Hello <?php echo  $_SESSION["user_name"] ?>!</p>
                        <form action="logout.php" method="post">
                            <input type="submit" class="btn btn-dark" value="Log out" name="logout">
                        </form>
                        <div class="text-center pt-3 pb-2">
                            <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-todo-list/check1.png" alt="Check" width="60">
                            <h2 class="my-4">TODO list</h2>
                        </div>
                        <div class="container searchCont col-md-10 ">
                             <div class="search "> <i class="fa fa-search"></i>
                                 <form action="">
                                     <input type="text" class="form-control" placeholder="Search" name="inputsearch" value="<?=$searchvalue?>">
                                     <button type="submit" class="btn btn-primary">Search</button>
                                 </form>
                             </div>
                        </div>
                        <div class="container">
                            <div class="d-flex flex-row justify-content-between">
                                <div class="block col-md-9">
                                    <table class="table text-white mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Task</th>
                                            <th scope="col">Info</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_REQUEST["Editform"])){
                                                $dat=$yhendus->prepare("SELECT id, tahtaeg, oppeaine, tooliik, task FROM taskid WHERE id = ?");
                                                $dat->bind_param("i", $_REQUEST['Editform']);
                                                $dat->bind_result($id,$tahtaeg, $oppeaine, $tooliik, $task);
                                                $dat->execute();
                                                $dat->fetch();
                                                $dat->close();
                                                echo "<div class='container'>
                                                                 <form action='$_SERVER[PHP_SELF]'>
                                                                    <div class='row'>
                                                                    <input type='hidden' name='idEdit' value='$id'>
                                                                        <div class='form-group col-sm-3'>
                                                                            <label for='oppeaine'>Subject:</label>
                                                                            <input type='text' name='oppeaine' value='$oppeaine'>
                                                                        </div>
                                                                        <div class='form-group col-sm'>
                                                                            <label for='tooliik'>Task:</label>
                                                                            <input type='text' name='tooliik' value='$tooliik'>
                                                                        </div>
                                                                        <div class='form-group col-sm'>
                                                                            <label for='info'>Info:</label>
                                                                            <input type='text' name='info' value='$task'>
                                                                        </div>
                                                                        <div class='form-group col-sm'>
                                                                            <label for='tahtaeg'>Deadline::</label>
                                                                            <input type='date' name='tahtaeg' value='$tahtaeg'>
                                                                        </div>
                                                                    </div>
                                                                    <div class='row'>
                                                                       <div class='pt-3'>
                                                                          <input class='btn btn-light' type='submit' name='edit' value='Edit'>
                                                                       </div>
                                                                    </div>
                                                                 </form>
                                                              </div>
                                                        ";
                                            }
                                            if(!empty(isset($_REQUEST["inputsearch"]))) {
                                                $input= $_REQUEST["inputsearch"];
                                                $data=$yhendus->prepare("select id, tahtaeg, oppeaine, tooliik, task from taskid where tooliik like '%$input%' and user = '$user' || tahtaeg like '%$input%' and user = '$user' || oppeaine like '%$input%' and user = '$user' || task like '%$input%' and user = '$user'");
                                                $data->bind_result($id, $tahtaeg, $oppeaine, $tooliik, $task);
                                                $data->execute();
                                            }
                                            else{
                                                $data=$yhendus->prepare("SELECT id, tahtaeg, oppeaine, tooliik, task FROM taskid WHERE user = ?");
                                                $data->bind_param("i", $user);
                                                $data->bind_result($id, $tahtaeg, $oppeaine, $tooliik, $task);
                                                $data->execute();
                                            }
                                                while($data->fetch()){

                                                    echo "<tr class='fw-normal'>";

                                                    echo "<th><span class='ms-2'>".$oppeaine."</span></th>";
                                                    echo "<td class='align-middle'><span>".htmlspecialchars($tooliik)."</span></td>";
                                                    echo "<td class='align-middle'>".htmlspecialchars($task)."</td>";
                                                    echo "<td class='align-middle'><h6 class='mb-0'><span class='badge bg-danger'>".htmlspecialchars($tahtaeg)."</span></h6></td>";

                                                    echo"<td class='align-middle'><a href='$_SERVER[PHP_SELF]?Delete=$id' data-mdb-toggle='tooltip' title='Remove'><svg width='2em' height='2em' viewBox='0 0 16 16' class='bi bi-x-circle' fill='#F44336' xmlns='http://www.w3.org/2000/svg'>
                                                    <path fill-rule='evenodd' d='M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                                        <path fill-rule='evenodd' d='M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z'/>
                                                        <path fill-rule='evenodd' d='M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z'/>
                                                    </svg></a></td>";
                                                    echo"<td class='align-middle'><a href='$_SERVER[PHP_SELF]?Editform=$id' data-mdb-toggle='tooltip' title='Edit'><svg xmlns='http://www.w3.org/2000/svg' width='2em' height='2em' fill='#A7FFEB' class='bi bi-pencil' viewBox='0 0 16 16'>
                                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                                    </svg></a></td>";

                                                    echo "</tr>";

                                                }
                                                ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="block">
                                    <form>
                                        <div class="form-group">
                                            <label for="Input1">Task</label>
                                            <input type="text" class="form-control" id="Input1" placeholder="task" name="task">
                                        </div>
                                        <div class="form-group">
                                            <label for="Select1">Subject</label>
                                            <select class="form-control" id="Select1" name="oppeaine">
                                                <option>Multimeedia</option>
                                                <option>Programeerimine</option>
                                                <option>Kontoritarkvara</option>
                                                <option>Rakendus testimine</option>
                                                <option>Koolieksam</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="Textarea1">Info</label>
                                            <textarea class="form-control" id="Textarea1" rows="3" placeholder="Info" name="tooliik"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="Textarea1">Deadline</label>
                                            <div>
                                                <input type="date" name="tahtaeg">
                                            </div>
                                        </div>
                                        <div class="form-group pt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                                            <input class="btn btn-light" type="submit" value="Add" name="Add">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
</body>
</html>