import DS from 'ember-data';

export default DS.Model.extend({
  name: DS.attr('string'),
  favoritecolor: DS.attr('string'),
  email: DS.attr('string'),
  friends: DS.attr({
    defaultValue() {
      return {};
    }
  })
});
