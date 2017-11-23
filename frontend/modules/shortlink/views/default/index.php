<?php

use \app\modules\shortlink\ShortLinkAsset;

$asset = ShortLinkAsset::register($this);
?>

<div class="row">
    <div class="col-md-12">
        <h1 v-show="!itemEdit">Создать короткую ссылку</h1>
        <h1 v-show="itemEdit">Изменить ссылку #{{itemEdit ? itemEdit.id : ''}}</h1>

        <div class="input-group">
            <input type="text" v-on:keyup.enter="addLink" v-show="!itemEdit" v-model="newLink" class="form-control" placeholder="https://very-long-long-link.com">
            <input type="text" v-on:keyup.enter="updateLink" v-show="itemEdit" v-model="newLink" class="form-control" placeholder="https://very-long-long-link.com">

            <span class="input-group-btn">
                <button v-on:click="addLink" v-show="!itemEdit" class="btn btn-default" type="button">Добавить</button>

                <button v-on:click="updateLink" v-show="itemEdit" class="btn btn-success" type="button">Обновить</button>
                <button v-on:click="cancelUpdateLink" v-show="itemEdit" class="btn btn-danger" type="button">Отменить</button>
            </span>
        </div><!-- /input-group -->

        <div class="alert alert-danger alert-dismissible" role="alert" v-show="errorMessage">
            <strong>Внимание!</strong> {{errorMessage}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h2>Список ссылок</h2>

        <button class="btn btn-success" v-show="existFilter" v-on:click="updateListLink">Применить фильтр</button>
        <button class="btn btn-default" v-show="existFilter" v-on:click="clearFilter">Очисить фильтр</button>

        <table class="table table-striped" v-show="items.length > 0">
            <thead>
                <tr>
                    <th style="width:100px">ID</th>
                    <th>URL</th>
                    <th style="width:100px">Код</th>
                    <th title="Операции">Опе.</th>
                </tr>
            </thead>
            <filter>
            <tr>
                <th><input type="text" class="form-control" v-model="filter.id" v-on:keyup.enter="updateListLink"></th>
                <th><input type="text" class="form-control" v-model="filter.url" v-on:keyup.enter="updateListLink"></th>
                <th><input type="text" class="form-control" v-model="filter.cod" v-on:keyup.enter="updateListLink"></th>
                <th></th>
            </tr>
            </filter>
            <tbody>
                <tr v-for="item in items">
                    <td>{{item.id}}</td>
                    <td>{{item.url}}</td>
                    <td><a target="_blank" v-bind:href="getLinkWidthCode(item)">{{item.cod}}</a></td>
                    <th>
                        <a href="#" title="Удалить" v-on:click.stop="removeLink(item)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                        <a href="#" title="Редактировать" v-on:click.stop="editLink(item)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    </th>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<div class="row" v-show="items.length == 0">
    <div class="col-md-6">
        <div class="alert alert-info" role="alert">Нет данных</div>
    </div>
</div>
