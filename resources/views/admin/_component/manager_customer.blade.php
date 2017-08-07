@extends('admin.master')
@section('style')
{{ Html::style('bower/AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}
@endsection

@section('content')
<div class="content-wrapper" id="manager_servece">
    <section class="content-header">
        <h1>
            {{ __('Customer') }}
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    {{ __('Home') }}
                </a>
            </li>
            <li>
                <a href="#">
                    {{ __('Manager') }}
                </a>
            </li>
            <li class="active">
                {{ __('Customer') }}
            </li>
        </ol>
    </section>
    <br>
    <div class="col-md-4 col-md-offset-7">
       <label class="col-md-4">{{ __('Number User') }}</label>
       <div class="form-group col-md-8 select_booking_manage">
        <select  class="form-control" id="sel1" v-on:change="selectPerPage">
            <option value="" selected>{{ __('Select') }}</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
        </div> 
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Manager Customer') }}
                            <span class="label label-warning">
                                @{{ items.length}}            
                            </span>
                        </h3>
                        <button class="col-md-offset-1 btn btn-success" v-on:click="addItem">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('Create Customer') }}
                        </button>
                    </div>
                    <div class="box-body over-flow-edit">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Phone') }}</th>
                                    <th>{{ __('Gender') }}</th>
                                    <th>{{ __('Permision') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in items">
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.name }}</td>
                                    <td>@{{ item.email }}</td>
                                    <td>@{{ item.phone }}</td>
                                     <td v-if="item.gender == 0">
                                        <span class="label label-infor">
                                            {{ __('Male') }}
                                        </span>
                                    </td>
                                    <td v-if="item.gender == 1">
                                        <span class="label label-infor">
                                            {{ __('Famele') }}
                                        </span>
                                    </td>
                                    <td v-else>
                                        <span class="label label-danger">
                                            {{ __('Orther') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permision == 0">
                                        <span class="lable label-success">
                                            {{ __('Nomal') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permision == 1">
                                        <span class="lable label-success">
                                            {{ __('Assistant') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permision == 2">
                                        <span class="label label-success">
                                            {{ __('Main_Worker') }}
                                        </span>
                                    </td>
                                    <td v-if="item.permision == 3">
                                        <span class="label label-success">
                                            {{ __('Admin') }}
                                        </span>
                                    </td>
                                    <td v-else>
                                        <span class="label label-warning">
                                            {{ __('Unknown') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" v-on:click="edit_Service(item)"><i class="fa fa-fw  fa-eyedropper get-color-icon-edit" ></i></a>
                                        <a href="javascript:void(0)" v-on:click="comfirmDeleteItem(item)"><i class="fa fa-fw  fa-close get-color-icon-delete" ></i></a>
                                        <a href="javascript:void(0)" v-on:click="viewUser(item)"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Create Customer') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="text" name="name" class="form-control" v-model="newItem.name"/>
                            <label for="name">{{ __('Email') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="email" name="email" class="form-control" v-model="newItem.email"/>
                            <label for="name">{{ __('Phone') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="email" name="phone" class="form-control" v-model="newItem.phone"/>
                            <label for="name">{{ __('Password') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="email" name="password" class="form-control" v-model="newItem.password"/>
                            <label for="name">{{ __('Confirm Password') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="email" name="password_confirmation" class="form-control" v-model="newItem.password_confirmation"/>
                            <div>
                             <label for="name">{{ __('Birthday') }}</label>
                                <input type="date" class="form-control" name="birthday"  v-model="newItem.birthday">
                            </div>
                            <br>
                            <label for="name">{{ __('Department') }}</label>
                             <div class="form-group select_booking_manage">
                                <select  class="form-control" id="sel1" v-on:change="selectPerPage">
                                    <option value="" selected>{{ __('Select Department') }}</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                            </div> 
                            <label for="name">{{ __('Gender') }}</label>
                                 <select  class="form-control" id="sel1" v-on:change="selectPerPage">
                                    <option value="" selected>{{ __('Select Gender') }}</option>
                                    <option value="0">male</option>
                                    <option value="1">female</option>
                                    <option value="5">orther</option>
                                </select>
                            <label for="name">{{ __('Permission') }}</label>
                                 <select  class="form-control" id="sel1" v-on:change="selectPerPage">
                                    <option  value="" selected>{{ __('Select Gender') }}</option>
                                    <option value="0">NOMAL</option>
                                    <option value="1">ASSISTANT</option>
                                    <option value="2">MAIN_WORKER</option>
                                    <option value="3">ADMIN</option>
                                </select>
                            <label for="name">{{ __('Specialize') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="text" name="specialize" class="form-control" v-model="newItem.specialize"/>
                            <label for="name">{{ __('About Me') }}</label>
                                <span class="text-danger">(*)</span>
                                <textarea class="form-control" name="about_me" rows="5" v-model="newItem.about_me"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Create') }}
                            </button>
                            <button class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                {{ __('Close') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Detail Customer') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">
                        <div class="panel panel-success">
                            <div class="panel-heading">{{__('Information')}}</div>
                                <div class="panel-body">
                                    <div class="col-sm-4">
                                        <p>Name:  @{{fillItem.name}} </p>
                                        <p>Email:  @{{fillItem.email}} </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Phone:  @{{fillItem.phone}} </p>
                                        <p v-if="fillItem.gender == 0">
                                            {{__('Gender:') }}
                                            <span class="label label-danger">
                                                {{__('Male') }}
                                            </span>
                                        </p>
                                        <p v-if="fillItem.gender == 1">
                                            {{__('Gender:') }}
                                            <span class="label label-danger">
                                                {{__('Famele') }}
                                            </span>
                                        </p>
                                        <p v-else>
                                            {{__('Gender:') }}
                                            <span class="label label-danger">
                                                {{__('Orther') }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Name:  @{{fillItem.name}} </p>
                                        <p>Name:  @{{fillItem.name}} </p>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                  {{ __('About Customer') }}
                                </button>
                                <br>
                                <div class="collapse" id="collapseExample">
                                    <div class="well">
                                        @{{ fillItem.about }}
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                {{ __('Close') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- comfirm delete item -->
     <div class="modal fade" id="delete-item" tabindex="-1" role="dialog" aria-labelledby="Heading" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                    <h4 class="modal-title custom_align" id="Heading">{{ trans('admin.deleteUser') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-warning-sign"></span> {{ trans('admin.user_comfirm_delete') . ': ' }} @{{ deleteItem.name }}
                    </div>
                </div>
                <div class="modal-footer ">
                    <a href="javascript:void(0)" v-on:click="delItem(deleteItem.id)" class="btn btn-danger">
                        <span class="glyphicon glyphicon-ok-sign"></span> {{ trans('admin.yes') }}
                    </a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">
                        <span class="glyphicon glyphicon-remove"></span> {{ trans('admin.no') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
     {{-- edit service --}}
    <div class="modal fade" id="edit_Service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('Update Service') }}</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateService(fillItem.id)">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                                <span class="text-danger">(*)</span>
                                    <input type="text" name="name" class="form-control" v-model="fillItem.name"/>
                            <label for="name">{{ __('admin.Short_description') }}</label>
                                <input type="text" name="short_description" class="form-control" v-model="fillItem.short_description"/>
                            <label for="name">{{ __('admin.Description') }}</label>
                                <textarea type="text" name="description" class="form-control" v-model="fillItem.description">
                                </textarea>
                            <label for="name">{{ __('Price') }}</label>
                                <span class="text-danger">(*)</span>
                                <input type="number" name="price" class="form-control" v-model="fillItem.price"/>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-plus" aria-hidden="true"></i> {{ __('Update') }}
                            </button>
                            <button class="btn btn-default" data-dismiss="modal">
                                <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                {{ __('Close') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {{ Html::script('js/admin/manager_customer_admin.js') }}
@endsection
