import Ember from 'ember';

export default Ember.Route.extend({
  model(userId){
    return this.store.findRecord('user', parseInt(userId.userId) );
  },
  actions: {
    deleteFriend(userId, friendId){
      return Ember.$.getJSON(`${userId}/${friendId}`);
    }
  }
});
