import DS from 'ember-data';

export default DS.model.extend({
  name: DS.attr('string'),
  favorite_color: DS.attr('string'),
  email: DS.attr('string')
})
