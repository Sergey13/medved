$(function () {


  app.views = {};
  app.models = {};
  app.collections = {};
  app.AppCollection = [];
  app.func = {
    fetchAppCollection: function (search, type) {

      var currentUrl = (window.history.state !== null) ? window.history.state.path : location.href;

      if (path != currentUrl) {

        app.collections.AppCollection = Backbone.Collection.extend({
          model: app.models.AppModal,
          url: createModelUrl(window.history.state.path)
        });

        app.AppCollection = [];
      }

      if (app.AppCollection.length === 0) {

        app.AppCollection = new app.collections.AppCollection;
        app.AppCollection.fetch();
      }

      app.func.initAppColllection(search, type);

    },
    initAppColllection: function (search, type) {

      var showView = new app.views.ShowList({
        el: '#' + type + '-list',
        search: search,
        type: type,
      });
    }
  };

  app.models.AppModal = Backbone.Model.extend({
    idAttribute: 'id'
  });

  if (window.history.state !== null) {

    var path = window.history.state.path;

  } else {

    var path = location.href;
  }


  app.collections.AppCollection = Backbone.Collection.extend({
    model: app.models.AppModal,
    url: createModelUrl(path)
  });


  app.views.ShowList = Backbone.View.extend({
    initialize: function (options) {

      this.listenTo(app.AppCollection, 'sync', this.render);

      this.search = options.search;
      this.type = options.type;

      if (app.AppCollection.length !== 0) {
        return this.render();
      }
      return this;
    },
    render: function () {

      $(app.loading_loader).hide();

      this.$el.empty();

      var that = this;

      var collection = app.AppCollection.toArray();

      var filter = this.type + '_filter';

      collection = eval(filter)(this.search, collection);

      _.each(collection, function (model, key) {

        model.set('key', (key + 1));

        var showItem = new app.views.ShowItem({
          model: model,
          collection: collection,
          type: that.type,
        });

        that.$el.append(showItem.el);
      });

      if (collection.length == 0) {
        this.$el.append('Ничего не найдено!');
      }

      init_library(this.$el);

      return this;
    }
  });

  app.views.ShowItem = Backbone.View.extend({
    tagName: 'tr',
    initialize: function (options) {

      this.template = _.template($('#' + options.type + '-item-template').html());
      return this.render();

    },
    render: function () {
      this.$el.html(this.template({model: this.model.toJSON()}));
      return this;

    }
  });

  $('body').on('click', '#search-equipment', function () {

    $(app.loading_loader).show();
    init_search_fields($(this), ['place', 'name', 'number', 'installation_date', 'pasport', 'inventory_number'], 'equipment');

  });

  $('body').on('click', '#search-component', function () {

    $(app.loading_loader).show();
    init_search_fields($(this), ['name', 'number'], 'component');

  });

  $('body').on('click', '#search-performer', function () {

    $(app.loading_loader).show();
    init_search_fields($(this), ['fio'], 'performer');

  });

  $('body').on('click', '#search-stock_incoming', function () {

    $(app.loading_loader).show();

    var type = $(this).data('type');

    init_search_fields($(this), ['date', type, 'type'], 'stock_incoming');

  });

  $('body').on('click', '#search-stock_expense', function () {

    $(app.loading_loader).show();

    var type = $(this).data('type');

    init_search_fields($(this), ['date', type, 'type', 'performer'], 'stock_expense');

  });

  $('body').on('click', '#search-record', function () {
    $(app.loading_loader).show();

    init_search_fields($(this), ['performer', 'date', 'type'], 'record');

  });

  $('body').on('click', '#search-place', function () {
    $(app.loading_loader).show();

    init_search_fields($(this), ['name'], 'place');

  });
});


function init_search_fields(elem, fields, type) {

  var data = {};

  _.each(fields, function (value, key) {
    data[value] = $(elem).parents('tr').find('[name="' + value + '"]').val();
  });

  app.func.fetchAppCollection(data, type);

  $('.reset-filtr').removeClass('hide');

}

function place_filter(search, collection) {

  if (search.name !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('name')).toLowerCase()).indexOf((search.name).toLowerCase()) + 1);
    });

  }

  return collection;
}


function equipment_filter(search, collection) {

  if (search.inventory_number !== '') {

    collection = collection.filter(function (model) {
      return ((model.get('inventory_number')).indexOf(search.inventory_number) + 1);
    });

  } else {

    if (search.place !== '') {

      collection = collection.filter(function (model) {
        console.log(model.get('place').name);
        return (((model.get('place').name).toLowerCase()).indexOf((search.place).toLowerCase()) + 1);
      });

    }

    if (search.name !== '') {

      collection = collection.filter(function (model) {
        return (((model.get('name')).toLowerCase()).indexOf((search.name).toLowerCase()) + 1);
      });

    }

    if (search.installation_date !== '') {

      search.installation_date = change_format_date(search.installation_date);

      collection = collection.filter(function (model) {
        return model.get('installation_date') == search.installation_date;
      });
    }

    if (search.pasport !== '') {

      collection = collection.filter(function (model) {
        return (((model.get('pasport')).toLowerCase()).indexOf((search.pasport).toLowerCase()) + 1);
      });

    }
  }

  return collection;
}


function component_filter(search, collection) {

  if (search.number !== '') {

    collection = collection.filter(function (model) {
      return ((model.get('number')).indexOf(search.number) + 1);
    });
  } else {

//        if (search.count_at !== '') {
//
//            collection = collection.filter(function (model) {
//                return model.get('count') >= search.count_at;
//            });
//
//        }
//
//        if (search.count_to !== '') {
//
//            collection = collection.filter(function (model) {
//                return model.get('count') <= search.count_to;
//            });
//
//        }

    if (search.name !== '') {

      collection = collection.filter(function (model) {
        return (((model.get('name')).toLowerCase()).indexOf((search.name).toLowerCase()) + 1);
      });

    }
  }

  return collection;
}


function performer_filter(search, collection) {

  if (search.fio !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('fio')).toLowerCase()).indexOf((search.fio).toLowerCase()) + 1);
    });

  }

  return collection;
}


function stock_incoming_filter(search, collection) {

  if (search.date !== '') {

    search.date = change_format_date(search.date);

    collection = collection.filter(function (model) {
      var model_date = (model.get('date')).split(' ')
      return model_date[0] == search.date;
    });
  }

  if (search.component !== undefined && search.component !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('component').name).toLowerCase()).indexOf((search.component).toLowerCase()) + 1);
    });
  }

  if (search.equipment !== undefined && search.equipment !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('equipment').name).toLowerCase()).indexOf((search.equipment).toLowerCase()) + 1);
    });
  }

  if (search.tool !== undefined && search.tool !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('tool').name).toLowerCase()).indexOf((search.tool).toLowerCase()) + 1);
    });
  }

  if (search.material !== undefined && search.material !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('material').name).toLowerCase()).indexOf((search.material).toLowerCase()) + 1);
    });
  }

  if (search.type !== '') {

    collection = collection.filter(function (model) {
      return model.get('type') == search.type;
    });
  }


  return collection;

}

function stock_expense_filter(search, collection) {

  if (search.date !== '') {

    search.date = change_format_date(search.date);

    collection = collection.filter(function (model) {
      var model_date = (model.get('date')).split(' ')
      return model_date[0] == search.date;
    });
  }

  if (search.date !== '') {

    search.date = change_format_date(search.date);

    collection = collection.filter(function (model) {
      var model_date = (model.get('date')).split(' ')
      return model_date[0] == search.date;
    });
  }

  if (search.component !== undefined && search.component !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('component').name).toLowerCase()).indexOf((search.component).toLowerCase()) + 1);
    });
  }

  if (search.equipment !== undefined && search.equipment !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('equipment').name).toLowerCase()).indexOf((search.equipment).toLowerCase()) + 1);
    });
  }

  if (search.tool !== undefined && search.tool !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('tool').name).toLowerCase()).indexOf((search.tool).toLowerCase()) + 1);
    });
  }

  if (search.material !== undefined && search.material !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('material').name).toLowerCase()).indexOf((search.material).toLowerCase()) + 1);
    });
  }

  if (search.performer !== '') {

    collection = collection.filter(function (model) {
      var performer = model.get('performer');
      if (model.get('performer') !== null) {
        return (((model.get('performer').fio).toLowerCase()).indexOf((search.performer).toLowerCase()) + 1);
      }
    });
  }

  if (search.type !== '') {

    collection = collection.filter(function (model) {
      return model.get('type') == search.type;
    });
  }

  return collection;

}

function record_filter(search, collection) {

  if (search.date !== '') {

    search.date = change_format_date(search.date);

    collection = collection.filter(function (model) {
      return model.get('date') == search.date;
    });
  }

  if (search.performer !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('performer').name).toLowerCase()).indexOf((search.performer).toLowerCase()) + 1);
    });
  }

  if (search.type !== '') {

    collection = collection.filter(function (model) {
      return (((model.get('type_of_repair').type).toLowerCase()).indexOf((search.type).toLowerCase()) + 1);
    });
  }

  return collection;


}

function createModelUrl(path) {

  if (path.indexOf('?') + 1) {
    var url = path + '&ajax=json';
  } else {
    var url = path + '?ajax=json';
  }

  return url;
}


function change_format_date(date) {

  var arr = date.split('.');

  return arr[2] + '-' + arr[1] + '-' + arr[0];
}