import Ember from 'ember';
import InfinityRoute from "ember-infinity/mixins/route";

export default Ember.Route.extend(InfinityRoute, {
  model() {
    /* Load pages of the User Model, starting from page 1, in groups of 25. */
    return this.infinityModel("user", { perPage: 5, startingPage: 1 });
  }
});
