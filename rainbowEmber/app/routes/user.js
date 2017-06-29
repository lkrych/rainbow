import Ember from 'ember';

export default Ember.Route.extend({
  model(userId){
    return this.store.findRecord('user', parseInt(userId.userId) );
  },
  actions: {
    deleteFriend(userId){
      this.store.findRecord('user', parseInt(userId.userId), { backgroundReload: false }).then(function(post) {
        post.destroyRecord();
});
    }
  }
});
