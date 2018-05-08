<table class='table table-bordered'>
        <thead>
            <th>No</th>
            <th>UserID</th>
            <th>Username</th>
            <th>Phone</th>
            <th>GroupOf</th>
            <th>LastLogin</th>
            <th>Action</th>
        </thead>
        <tbody >
        <?php
            foreach ($users as $user) {
                $start++
                ?>
                <tr>
                <td ><?php echo $start ?>"</td>
                <td><?php echo $user->user_id ?></td>
                <td><?php echo $user->user_name ?></td>
                <td><?php echo $user->phone_no ?></td>
                <td><?php echo $user->group_of ?></td>
                <td><?php echo $user->last_login ?></td>
                <td>
                  <a data-toggle='modal' data-target='#edit_users' data-user="<?php echo $user->user_id ?>">
                    <button type='button' data-toggle='tooltip' class='edit_user' title='Edit User' style='background-color: black; color: white;'> <span class='fa fa-pencil-square-o'></span> </button>
                  </a>
                  <a data-toggle='modal' data-target='#del_users' data-user="<?php echo $user->user_id ?>">
                    <button type='button' data-toggle='tooltip' class='del_user' title='Hapus User' style='background-color: black; color: white;'> <span class='fa fa-eraser'></span> </button>
                  </a>
                </td>
                </tr>
            <?php
            }
            ?>
            </tbody></table>