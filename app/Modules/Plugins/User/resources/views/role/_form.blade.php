<div class="form-group form-group--table m-b-30">
    <label class="col-form-label">Nama Role</label>
    <div class="col-form-input">
        {!! Form::text('name', $role->name, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="checkbox-group checkbox-role">
            <div class="checkbox-role--parent">
                <div class="checkbox checkbox-inline checkall">                       
                    {!! Form::checkbox('permissions[]', 'post', (in_array('post', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                    <label for="post">Post</label>
                </div>
            </div>
            <ul class="checkbox-role--advance">
                <li>
                    <div class="checkbox checkbox-inline">
                        {!! Form::checkbox('permissions[]', 'add_post', (in_array('add_post', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="add_post">add_post</label>
                    </div>
                </li>
                <li>
                    <div class="checkbox checkbox-inline">                      
                        {!! Form::checkbox('permissions[]', 'edit_post', (in_array('edit_post', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="edit_post">edit_post</label>
                    </div>
                </li>
                <li>
                    <div class="checkbox checkbox-inline">
                        {!! Form::checkbox('permissions[]', 'edit_posts', (in_array('edit_posts', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="edit_posts">edit_posts</label>
                    </div>
                </li>
                <li>
                    <div class="checkbox checkbox-inline">
                        {!! Form::checkbox('permissions[]', 'publish_post', (in_array('publish_post', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="publish_post">publish_post</label>
                    </div>
                </li>
                <li>
                    <div class="checkbox checkbox-inline">
                        {!! Form::checkbox('permissions[]', 'publish_posts', (in_array('publish_posts', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="publish_posts">publish_posts</label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="checkbox-group checkbox-role">
            <div class="checkbox-role--parent">
                <div class="checkbox checkbox-inline checkall">                   
                    {!! Form::checkbox('permissions[]', 'user', (in_array('user', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                    <label for="user">User</label>
                </div>
            </div>
            <ul class="checkbox-role--advance">
                <li>
                    <div class="checkbox checkbox-inline">                        
                        {!! Form::checkbox('permissions[]', 'manage_user', (in_array('manage_user', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="manage_user">manage_user</label>
                    </div>
                </li>
                <li>
                    <div class="checkbox checkbox-inline">
                        {!! Form::checkbox('permissions[]', 'manage_role', (in_array('manage_role', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="manage_role">manage_role</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-sm-4">    
        <div class="checkbox-group checkbox-role">
            <div class="checkbox-role--parent">
                <div class="checkbox checkbox-inline checkall">                    
                    {!! Form::checkbox('permissions[]', 'banner', (in_array('banner', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                    <label for="banner">Banner</label>
                </div>
            </div>
            <ul class="checkbox-role--advance">
                <li>
                    <div class="checkbox checkbox-inline">                        
                        {!! Form::checkbox('permissions[]', 'manage_banner', (in_array('manage_banner', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="manage_banner">manage_banner</label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="checkbox-group checkbox-role">
            <div class="checkbox-role--parent">
                <div class="checkbox checkbox-inline checkall">                   
                    {!! Form::checkbox('permissions[]', 'menu', (in_array('menu', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                    <label for="menu">Menu</label>
                </div>
            </div>
            <ul class="checkbox-role--advance">
                <li>
                    <div class="checkbox checkbox-inline">                        
                        {!! Form::checkbox('permissions[]', 'manage_menu', (in_array('manage_menu', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="manage_menu">manage_menu</label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="checkbox-group checkbox-role">
            <div class="checkbox-role--parent">
                <div class="checkbox checkbox-inline checkall">                   
                    {!! Form::checkbox('permissions[]', 'slider', (in_array('slider', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                    <label for="slider">Slider</label>
                </div>
            </div>
            <ul class="checkbox-role--advance">
                <li>
                    <div class="checkbox checkbox-inline">                        
                        {!! Form::checkbox('permissions[]', 'manage_slider', (in_array('manage_slider', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="manage_slider">manage_slider</label>
                    </div>
                </li>
            </ul>
        </div>

        <div class="checkbox-group checkbox-role">
            <div class="checkbox-role--parent">
                <div class="checkbox checkbox-inline checkall">                  
                    {!! Form::checkbox('permissions[]', 'options', (in_array('options', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                    <label for="options">Options</label>
                </div>
            </div>
            <ul class="checkbox-role--advance">
                <li>
                    <div class="checkbox checkbox-inline">                       
                        {!! Form::checkbox('permissions[]', 'manage_options', (in_array('manage_options', $role->permissions)) ? true : false, ['class'=>'form-control']) !!}
                        <label for="manage_options">manage_options</label>
                    </div>
                </li>
            </ul>
        </div>


    </div>
</div>