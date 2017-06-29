import Ember from 'ember';

export default Ember.Route.extend({
  model(params){
    Ember.$.getJSON(`?userCount=${params.userCount}`).then((response) => {
      console.log(response);
      this.refresh();
      this.transitionTo('index');

    });
  }
});
