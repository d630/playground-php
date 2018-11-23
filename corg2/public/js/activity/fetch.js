//let Fetch = {

//  //
//  // Fetch.buttonAction
//  //

//  buttonAction: {
//    onReady: function() {
//      $(document).on('mousedown', '.my-button-activity-remove', Fetch.buttonAction.remove);
//      $(document).on('click', '.my-button-activity-remove', Activity.preventDefault);
//      $(document).on('mousedown', '.my-button-activity-add', Fetch.buttonAction.add);
//      $(document).on('click', '.my-button-activity-add', Activity.preventDefault);
//    },

//    remove: function(e) {
//      console.log('jo');
//      Activity.preventDefault(e);
//      $.when(Remove.activity(Activity.id))
//        .done(function() {
//          $.ajax({
//                 type: 'GET',
//                 url: '/activities/infos/0',
//                 dataType : 'json',
//                 data: {
//                   for: 'fetch'
//                 }
//          })
//          .done(function(next) {
//            Activity.id = next;
//            $.when(Fetch.getActivityNav(next))
//              .then(Activity.trigger($(`#activityNavLinks a[data-id=${next}]`), 'mousedown'));
//            if (!next) {
//              history.pushState({ corg: true, id: 0 , oid: 1}, '', '/activities');
//              Activity.assignDocumentLocation('/activities');
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
//      Activity.preventDefault(e);
//      history.pushState({ corg: true, id: Activity.id , oid: Activity.id}, '', '/activities');
//      Activity.togglePage('Add', [ 'Fetch' ])
//    }
//  },

//  //
//  // Fetch.getActivityNav
//  //

//  getActivityNav: function(id) {
//    $.ajax({
//           type: 'GET',
//           url: '/activities',
//           dataType : 'json',
//           data: {
//             for: 'fetch'
//           }
//    })
//      .done(function(activities) {
//        Fetch.setActivityCount(activities);
//        Fetch.appendActivityNavLinks(activities);
//        Fetch.setActiveActivityNavLinks(id);
//      });
//  },

//  setActivityCount: function(activities) {
//    $('#activityCount').text(Object.keys(activities).length);
//  },

//  appendActivityNavLinks: function(activities) {
//    $('.my-nav-link').remove();
//    $.each(activities, function(k, v) {
//      $('#activityNavLinks')
//        .append(
//                `<a class="nav-link my-nav-link" href="/activities/${k}" data-href="/activities/${k}" data-id="${k}" data-name="${v}">${k}|${v}</a>`);
//    });
//  },

//  setActiveActivityNavLinks: function(id) {
//    $(`#activityNavLinks a[data-id=${id}]`).addClass('active');
//  },


//  //
//  // Fetch.getActivity
//  //

//  getActivity: function(id) {
//      $.ajax({
//             type: 'GET',
//             url: '/activities/' + id,
//             dataType : 'json',
//             data: {
//               for: 'fetch'
//             }
//      })
//        .done(function(activity) {
//          Fetch.setActivity(activity);
//        });
//  },

//  setActivity: function(activity) {
//    // Activity.rec = JSON.parse(JSON.stringify(activity));
//    Activity.rec = Object.assign({}, activity);

//    $('#fetchActivity input[id=nickname]').attr('value', activity.employee_nickname);
//    $('#fetchActivity input[id=mtime]').attr('value', activity.mtime);
//    $('#fetchActivity input[id=org]').attr('value', activity.customer_org);
//    $('#fetchActivity label[id=orgLabel] > a').attr('href', '/customers/' + activity.customer_id);
//    $('#fetchActivity textarea[id=description]').html(activity.description);
//  },


//  //
//  // Fetch.getFiles
//  //

//  getFiles: function(id) {
//      $.ajax({
//             type: 'GET',
//             url: `/activities/${id}/files`,
//             dataType : 'json',
//             data: {
//               for: 'fetch'
//             }
//      })
//        .done(function(files) {
//          Fetch.setFilesCount(files);
//          Fetch.emptyTableFiles();
//          Fetch.appendTableFiles(files);
//        });
//  },

//  setFilesCount: function(files) {
//   $('#filesCount').text(Object.keys(files).length);
//  },

//  emptyTableFiles: function() {
//    $('#tableFiles tr.my-table-row-files').empty();
//  },

//  appendTableFiles: function(files) {
//    $.each(files, function(k, v) {
//      $('#tableFiles > tbody:last')
//        .append($(`<tr class="my-table-row-files" data-id="${k}" data-href="/files/${k}">`)
//                .append(
//                        '<td>' + v.mtime + '</td>' +
//                        '<td>' + v.size + '</td>' +
//                        '<td>' + v.name + '</td>'
//                ));
//    });
//  },

//  //
//  // Fetch.changeActiveActivity
//  //

//  changeActiveActivity: {
//    onReady: function() {
//      $(document).on('click', 'a.my-nav-link', Activity.preventDefault);
//      $(document).on('mousedown', 'a.my-nav-link', Fetch.changeActiveActivity.set);
//      $(document).on('click', 'tr.my-table-row-files', function() {
//        Activity.assignDocumentLocation($(this).data('href'));
//      });
//    },

//    set: function() {
//      var old = $('a.my-nav-link.active').data('id');
//      var href = $(this).data('href');
//      var _id = $(this).data('id');
//      var activity = $(this).data('name');
//      Activity.id = _id;

//      $('a.my-nav-link.active').removeClass('active');
//      // $(this).addClass('active');
//      $(`#activityNavLinks a[data-id=${_id}]`).addClass('active');

//      $.when(Fetch.getActivity(Activity.id), Fetch.getFiles(Activity.id))
//        .then(function() {
//          Activity.setDocumentTitle(activity);
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
//        active = $(`#activityNavLinks a[data-id=${e.originalEvent.state.id}]`);
//        active.addClass('active');
//        Activity.setDocumentTitle(active.data('name'));
//        Fetch.getActivity(e.originalEvent.state.id);
//        Fetch.getFiles(e.originalEvent.state.id);
//      }
//    }
//  },

//  //
//  // Fetch.searchInput
//  //

//  searchInput: {
//    onReady: function() {
//      $(document).on('input', ':input[id=activitySearch]', Fetch.searchInput.toggle);
//    },

//    toggle: function() {
//      var val = $(this).val().toLowerCase();
//      $('#activityNavLinks a.my-nav-link')
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
//      Fetch.main.build(Activity.id);
//      Fetch.main.setEvents();
//    },

//    build: function(id) {
//      Fetch.getActivityNav(id);
//      Fetch.getActivity(id);
//      Fetch.getFiles(id);
//    },

//    setEvents: function() {
//      Fetch.buttonAction.onReady();
//      Fetch.changeActiveActivity.onReady();
//      Fetch.popState.onReady();
//      Fetch.searchInput.onReady();
//    },
//  }
//};

