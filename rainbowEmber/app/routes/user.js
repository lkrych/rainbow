import Ember from 'ember';

export default Ember.Route.extend({
  model(userId){
    return this.store.findRecord('user', userId );
  }
});
