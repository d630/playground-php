//let Fetch = {

//  //
//  // Fetch.buttonAction
//  //

//  buttonAction: {
//    onReady: function() {
//      $(document).on('mousedown', '.my-button-customer-remove', Fetch.buttonAction.remove);
//      $(document).on('click', '.my-button-customer-remove', Customer.preventDefault);
//      $(document).on('mousedown', '.my-button-customer-add', Fetch.buttonAction.add);
//      $(document).on('click', '.my-button-customer-add', Customer.preventDefault);
//      $(document).on('mousedown', '.my-button-customer-edit', Fetch.buttonAction.edit);
//      $(document).on('click', '.my-button-customer-edit', Customer.preventDefault);
//      $(document).on('mousedown', '.my-button-customer-export', Fetch.buttonAction.export);
//      $(document).on('click', '.my-button-customer-export', Customer.preventDefault);
//    },

//    remove: function(e) {
//      Customer.preventDefault(e);
//      $.when(Remove.customer(Customer.id))
//        .done(function() {
//          $.ajax({
//                 type: 'GET',
//                 url: '/customers/infos/0',
//                 dataType : 'json',
//                 data: {
//                   for: 'fetch'
//                 }
//          })
//          .done(function(next) {
//            Customer.id = next;
//            $.when(Fetch.getCustomerNav(next))
//              .then(Customer.trigger($(`#orgNavLinks a[data-id=${next}]`), 'mousedown'));
//            if (!next) {
//              history.pushState({ corg: true, id: 0 , oid: 1}, '', '/customers');
//              Customer.assignDocumentLocation('/customers');
//            }
//          })
//          .fail(function(msg) {
//            console.log(msg);
//          });
//        })
//        .fail(function(msg) {
//          // TODO
//          console.log(msg);
//        });
//    },

//    add: function(e) {
//      Customer.preventDefault(e);
//      history.pushState({ corg: true, id: Customer.id , oid: Customer.id}, '', '/customers');
//      Customer.togglePage('Add', [ 'Fetch', 'Edit' ])
//    },

//    edit: function(e) {
//      Customer.preventDefault(e);
//      history.pushState({ corg: true, id: Customer.id , oid: Customer.id}, '', '/customers/' + Customer.id);
//      Customer.togglePage('Edit', [ 'Fetch', 'Add' ]);
//    },

//    export: function(e) {
//      Customer.preventDefault(e);
//      Export.toVcard(Customer.id);
//    }
//  },

//  //
//  // Fetch.getCustomerNav
//  //

//  getCustomerNav: function(id) {
//      $.ajax({
//             type: 'GET',
//             url: '/customers',
//             dataType : 'json',
//             data: {
//               for: 'fetch'
//             }
//      })
//        .done(function(customers) {
//          Fetch.setOrgCount(customers);
//          Fetch.appendOrgNavLinks(customers);
//          Fetch.setActiveOrgNavLinks(id);
//        });
//  },

//  setOrgCount: function(customers) {
//    $('#orgCount').text(Object.keys(customers).length);
//  },

//  appendOrgNavLinks: function(customers) {
//    $('.my-nav-link').remove();
//    $.each(customers, function(k, v) {
//      $('#orgNavLinks')
//        .append(
//                `<a class="nav-link my-nav-link" href="/customers/${k}" data-href="/customers/${k}" data-id="${k}" data-org="${v}">${k}|${v}</a>`);
//    });
//  },

//  setActiveOrgNavLinks: function(id) {
//    $(`#orgNavLinks a[data-id=${id}]`).addClass('active');
//  },


//  //
//  // Fetch.getCustomer
//  //

//  getCustomer: function(id) {
//      $.ajax({
//             type: 'GET',
//             url: '/customers/' + id,
//             dataType : 'json',
//             data: {
//               for: 'fetch'
//             }
//      })
//        .done(function(customer) {
//          Fetch.setCustomer(customer);
//        });
//  },

//  setCustomer: function(customer) {
//    // Customer.rec = JSON.parse(JSON.stringify(customer));
//    Customer.rec = Object.assign({}, customer);
//    Edit.setCustomer(Customer.rec);

//    $('#fetchOrg input[id=nickname]').attr('placeholder', customer.employee_nickname);
//    $('#fetchOrg input[id=rev]').attr('placeholder', customer.rev);
//    $('#fetchOrg input[id=url]').attr('placeholder', customer.url);
//    $('#fetchOrg input[id=post_office_box]').attr('placeholder', customer.post_office_box);
//    $('#fetchOrg input[id=street_address]').attr('placeholder', customer.street_address);
//    $('#fetchOrg input[id=extended_address]').attr('placeholder', customer.extended_address);
//    $('#fetchOrg input[id=locality]').attr('placeholder', customer.locality);
//    $('#fetchOrg input[id=region]').attr('placeholder', customer.region);
//    $('#fetchOrg input[id=postal_code]').attr('placeholder', customer.postal_code);
//    $('#fetchOrg input[id=country_name]').attr('placeholder', customer.country_name);
//    $('#fetchOrg input[id=role]').attr('placeholder', customer.role);
//    $('#fetchOrg input[id=family_name]').attr('placeholder', customer.family_name);
//    $('#fetchOrg input[id=given_name]').attr('placeholder', customer.given_name);
//    $('#fetchOrg input[id=additional_name]').attr('placeholder', customer.additional_name);
//    $('#fetchOrg input[id=honorific_prefix]').attr('placeholder', customer.honorific_prefix);
//    $('#fetchOrg input[id=honorific_suffix]').attr('placeholder', customer.honorific_suffix);
//    $('#fetchOrg input[id=tel]').attr('placeholder', customer.tel);
//    $('#fetchOrg input[id=email]').attr('placeholder', customer.email);
//  },

//  //
//  // buttonAssociations
//  //

//  getAssociations: function(id) {
//      $.ajax({
//             type: 'GET',
//             url: `/customers/${id}/associations`,
//             dataType : 'json',
//             data: {
//               for: 'fetch'
//             }
//      })
//        .done(function(associations) {
//          Fetch.setAssociationsCount(associations);
//          Fetch.emptyTableAssociations();
//          Fetch.appendTableAssociations(associations);
//        });
//  },

//  setAssociationsCount: function(associations) {
//    $('#associatonsCount').text(Object.keys(associations).length);
//  },

//  emptyTableAssociations: function() {
//    $('#tableAssociations tr.my-table-row-associations').empty();
//  },

//  appendTableAssociations: function(associations) {
//    $.each(associations, function(k, v) {
//      $('#tableAssociations > tbody:last')
//        .append($(`<tr class="my-table-row-associations" data-id="${k}" data-org="${v}" data-href="/customers/${k}">`).html(v));
//    });
//  },

//  //
//  // buttonActivities
//  //

//  getActivities: function(id) {
//      $.ajax({
//             type: 'GET',
//             url: `/customers/${id}/activities`,
//             dataType : 'json',
//             data: {
//               for: 'fetch'
//             }
//      })
//        .done(function(activities) {
//          Fetch.setActivitiesCount(activities);
//          Fetch.emptyTableActivities();
//          Fetch.appendTableActivities(activities);
//        });
//  },

//  setActivitiesCount: function(activities) {
//   $('#activitiesCount').text(Object.keys(activities).length);
//  },

//  emptyTableActivities: function() {
//    $('#tableActivities tr.my-table-row-activities').empty();
//  },

//  appendTableActivities: function(activities) {
//    $.each(activities, function(k, v) {
//      $('#tableActivities > tbody:last')
//        .append($(`<tr class="my-table-row-activities" data-id="${k}" data-href="/activities/${k}">`)
//                .append(
//                        '<td>' + v.mtime + '</td>' +
//                        '<td>' + v.name + '</td>' +
//                        '<td>' + v.description + '</td>'
//                ));
//    });
//  },

//  //
//  // Fetch.changeActiveCustomer
//  //

//  changeActiveCustomer: {
//    onReady: function() {
//      $(document).on('click', 'a.my-nav-link, tr.my-table-row-associations', Customer.preventDefault);
//      $(document).on('mousedown', 'a.my-nav-link', Fetch.changeActiveCustomer.set);
//      $(document).on('click', 'tr.my-table-row-associations', Fetch.changeActiveCustomer.set);
//      $(document).on('click', 'tr.my-table-row-activities', function() {
//        Customer.assignDocumentLocation($(this).data('href'));
//      });
//    },

//    set: function() {
//      var old = $('a.my-nav-link.active').data('id');
//      var href = $(this).data('href');
//      var _id = $(this).data('id');
//      var org = $(this).data('org');
//      Customer.id= _id;

//      $('a.my-nav-link.active').removeClass('active');
//      // $(this).addClass('active');
//      $(`#orgNavLinks a[data-id=${_id}]`).addClass('active');

//      $.when(Fetch.getCustomer(_id), Fetch.getAssociations(_id), Fetch.getActivities(_id))
//        .then(function() {
//          Customer.setDocumentTitle(org);
//          history.pushState({ corg: true, id: _id , oid: old}, '', href);
//        });
//    },
//  },

//  //
//  // Fetch.popState
//  //

//  popState: {
//    onReady: function() {
//      $(window).on('popstate', Fetch.popState.set);
//    },

//    set: function(e) {
//      if (e.originalEvent.state !== null) {
//        $('a.my-nav-link.active').removeClass('active');
//        active = $(`#orgNavLinks a[data-id=${e.originalEvent.state.id}]`);
//        active.addClass('active');
//        Customer.setDocumentTitle(active.data('org'));
//        Fetch.getCustomer(e.originalEvent.state.id);
//        Fetch.getAssociations(e.originalEvent.state.id);
//        Fetch.getActivities(e.originalEvent.state.id);
//      }
//    }
//  },

//  //
//  // Fetch.searchInput
//  //

//  searchInput: {
//    onReady: function() {
//      $(document).on('input', ':input[id=orgSearch]', Fetch.searchInput.toggle);
//    },

//    toggle: function() {
//      var val = $(this).val().toLowerCase();
//      $('#orgNavLinks a.my-nav-link')
//        .filter(function() {
//          $(this).toggle($(this).html().toLowerCase().indexOf(val) > -1)
//        });
//    }
//  },

//  //
//  // main
//  //

//  main: {
//    init: function() {
//      Fetch.main.build(Customer.id);
//      Fetch.main.setEvents();
//    },

//    build: function(id) {
//      Fetch.getCustomerNav(id);
//      Fetch.getCustomer(id);
//      Fetch.getAssociations(id);
//      Fetch.getActivities(id);
//    },

//    setEvents: function() {
//      Fetch.buttonAction.onReady();
//      Fetch.changeActiveCustomer.onReady();
//      Fetch.popState.onReady();
//      Fetch.searchInput.onReady();
//    },
//  }
//};
