import DS from 'ember-data';

export default DS.Model.extend({
  name: DS.attr('string'),
  favorite_color: DS.attr('string'),
  email: DS.attr('string')
});
