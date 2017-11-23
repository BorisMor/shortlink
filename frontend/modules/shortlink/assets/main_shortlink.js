var formShortLink = new Vue({
    el: "#short-link",
    data: {
        newLink: undefined,
        itemEdit: undefined,
        errorMessage: undefined,
        filter: {
            id: '',
            cod: '',
            url: ''
        },
        items: []
    },
    computed: {
        existFilter: function () {
            var f = this.filter;
            return f.id || f.cod || f.url
        }
    },
    mounted: function() {
        this.$nextTick(function() {
            this.updateListLink();
        });
    },
    methods: {
        setError: function(error) {
            if (typeof error === "string") {
                this.errorMessage = error;
                return error;
            }

            if (typeof error === "object") {
                var s = '';
                for (var pro in error) {
                    s += this.setError(error[pro]) + "\n";
                }

                this.errorMessage = s;
                return s;
            }

            this.errorMessage = error;
        },

        // Добавить ссылку
        addLink: function(){
            var self = this;
            self.errorMessage = undefined;

            this.$http.put('/api/link', {url: this.newLink}).then(function(response) {
                console.log('put /api/link', response);

                var body = response.body;

                if (body.success) {
                    self.updateListLink();
                    self.newLink = undefined;
                } else {
                    self.setError(body.data);
                }
            }).catch(function (error) {
                debugger;
                console.error(error);
                self.setError(error.body.message);
            })
        },

        removeLink: function (item) {
            if (!confirm('Удалить ссылку ?')) {
               return null;
            }

            var self = this;
            this.$http.delete('/api/link/' + item.id).then(function(response) {
                var body = response.body;

                if (body.success) {
                    self.updateListLink();
                } else {
                    self.setError(body.data);
                }
            }).catch(function (error) {
                debugger;
                console.error(error);
                self.setError(error.body.message);
            })
        },

        // Перевести ссылку в режим редактирования
        editLink: function (item) {
            this.itemEdit = item;
            this.newLink = item.url;
            this.errorMessage = undefined;
        },

        // Обновить запись.itemEdit - обновляемая запись
        updateLink: function () {
            var self = this;
            self.errorMessage = undefined;

            if (!this.itemEdit) {
                self.errorMessage  = 'Не указан элемент для редактирования'
            }

            this.$http.post('/api/link/'  + this.itemEdit.id, {url: this.newLink}).then(function(response) {
                console.log('put /api/link', response);

                var body = response.body;

                if (body.success) {
                    self.updateListLink();
                    self.itemEdit = undefined;
                    self.newLink = undefined;
                } else {
                    self.setError(body.data);
                }
            }).catch(function (error) {
                debugger;
                console.error(error);
                self.setError(error.body.message);
            })
        },

        // Отменить редактирование
        cancelUpdateLink: function () {
            this.errorMessage = undefined;
            this.itemEdit = undefined;
            this.newLink = undefined;
        },

        getLinkWidthCode: function (item) {
            return location.origin + "/" + item.cod
        },

        // Очистить фильттр
        clearFilter: function () {
            this.filter = {id: undefined, cod: undefined, url: undefined};
            this.updateListLink();
        },

        // Обновить список ссылок
        updateListLink: function () {
            var self = this;
            var params = jQuery.param(this.filter);
            this.$http.get('/api/link?' + params).then(function(response) {
                console.log('get /api/link', response);

                var body = response.body;
                var success = body.success;

                if (success) {
                    self.items = body.data;
                } else {
                    self.setError(body.data);
                }
            }).catch(function (error) {
                debugger;
                console.error(error);
                self.setError(error.body.message);
            })
        }
    }
});