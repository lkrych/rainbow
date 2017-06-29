import Ember from 'ember';

export default Ember.Route.extend({
  model(userId){
    return this.store.findRecord('user', parseInt(userId.userId) );
  },
  actions: {
    deleteFriend(userId, friendId){
      Ember.$.getJSON(`${userId}/${friendId}`);
      this.transitionTo('index');
    }
  }
});
