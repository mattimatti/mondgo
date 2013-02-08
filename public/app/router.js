define([
  // Application.
  "app",

  // Modules.
  "modules/song",

],

function(app,Song) {

  // Defining the application router, you can attach sub routers here.
  var Router = Backbone.Router.extend({


    initialize: function() {
      // TODO Clean this up...
      var collections = {
        // Set up the songs.
        songs: new Song.Collection()
      };

      // Ensure the router has references to the collections.
      _.extend(this, collections);


      
      

    },



    routes: {
      "": "index",
      "song/:id": "songDetail",
    },



    index: function() {

      var me = this;

      me.reset();

      this.before(function(){

      

      // Use main layout and set Views.
      app.useLayout("main-layout").setViews({
        ".songs": new Song.Views.List(me)
      }).render();

      });



    },


    songDetail: function(id) {

      console.log("songDetail "+ id );

      console.log(id);


      var me = this;

       this.before(function(){

          //console.log(me.songs);
          var song = me.songs.get(id);

          console.log(song);

           app.useLayout("main-layout").setViews({
            ".songs": new Song.Views.Detail({model:song})
          }).render();

       });



    },



    // Shortcut for building a url.
    go: function() {
      return this.navigate(_.toArray(arguments).join("/"), true);
    },





    before:function (callback) {
        if (this.songs.length) {
            if (callback) callback();
        } else {
            this.songs.fetch({success:function () {
                if (callback) callback();
            }}
        );
        }
    },


    reset: function() {
      if (this.songs.length) {
        this.songs.reset();
      }
    }






  });

  return Router;

});
