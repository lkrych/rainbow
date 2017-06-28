import Ember from 'ember';


export default Ember.Route.extend({
  model(){ //grab information from server and return it
    return this.store.findAll('user');
  }
});
