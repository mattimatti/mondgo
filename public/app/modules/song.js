define([
  // Application.
  "app",

],

function(app) {

  var Song = app.module();



  Song.Model = Backbone.Model.extend({
    urlRoot: "/api/database/song",
    idAttribute: "_id",




    validate: function(attrs){
      if(attrs.name=="")return "error";
      if(attrs.artist=="")return "error";
    },


  });


  // Define the Collection
  Song.Collection = Backbone.Collection.extend({
    url: "/api/database/song",

    model: Song.Model,



    parse: function(response) {
      	return response.results;
    },

    initialize: function(models, options) {
      console.log("Song.Collection.initialize");
    }
  });



  // define the View
  Song.Views.Item = Backbone.View.extend({
    
    template: "song/item",

    tagName: "tr",

    serialize: function() {
      return { model: this.model };
    },

    events: {
      
      "click .update":          "selectUser",
      "click .delete":          "removeUser",
    },

     beforeRender: function() {

      },


      removeUser: function(){

          this.model.destroy();
          //app.router.songs.remove(this.model);

      },

    selectUser: function(ev) {
      var model = this.model;
      var name = model.get("_id");
      
      // set current model..
      app.router.songs.selectedSong = model;

      app.router.go("song", name);
    },

    initialize: function() {
      this.listenTo(this.model, "change", this.render);
    }
  });






  Song.Views.List = Backbone.View.extend({


    template: "song/list",


    serialize: function() {
      return { collection: this.options.songs };
    },



    beforeRender: function() {
     
        // render every item in collection
        this.options.songs.each(function(song) {

            this.insertView("table", new Song.Views.Item({
                model: song
            }));

     
      }, this);



    },

    afterRender: function() {
      
    },

    initialize: function() {

      this.listenTo(this.options.songs, {

        "reset": this.render,

        "add": this.render,

        "remove": this.render,

        "fetch": function() {
          this.$("table").parent().html("<img src='/app/img/spinner-gray.gif'>");
        }

      });
    },

    events: {
      "submit form": "createItem"
    },

    createItem: function(event) {

      this.options.songs.create({
        "name":this.$(".name").val(),
        "artist":this.$(".artist").val()
      });

      return false;
    }
  });




  // define the View
  Song.Views.Detail = Backbone.View.extend({
    
     template: "song/detail",

     tagName: "div",

      events: {
        "click .save":          "saveUser",
        "click .delete":         "removeUser",
      },

      serialize: function() {
        return { model: this.model };
      },


     beforeRender: function() {
      console.log("beforeRender");
        console.log(this.model);
    },


      removeUser: function(){
          console.log("removeUser");
          this.model.destroy({
            success:function () {
                window.history.back();
            }
        });
        return false;

      },

      saveUser: function(){
          console.log("saveUser");
          //this.model.destroy();
          //app.router.songs.remove(this.model);

      },

    initialize: function() {
      //this.listenTo(this.model, "change", this.render);
    }
  });









































  // Required, return the module for AMD compliance.
  return Song;

});
