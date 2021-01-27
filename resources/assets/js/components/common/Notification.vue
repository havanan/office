<template>
  <li class="dropdown top-menu-item-xs">
      <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
          <i class="icon-bell"></i> <span class="badge badge-xs badge-danger" v-if="$root.unread > 0" v-html="$root.unread"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-lg">
          <li class="notifi-title">
            <!-- <span class="label label-default pull-right">New 3</span> -->
            Thông báo
          </li>
          <li class="list-group notification-list" v-slimscroll="options">
              <!-- list item-->
              <a href="javascript:void(0);" v-for="(notify, index) in $root.notifications.items" :key="index" class="list-group-item wgd-notify" :class="notify.pivot.is_read ? '' : 'bg-gray'" @click="read($event.target, notify.pivot.id, index)">
                <div class="media">
                    <div class="pull-left p-r-10">
                      <em class="fa noti-custom" :class="notify.type === 'video' ? 'fa-video-camera' : 'fa-comment'"></em>
                    </div>
                    <div class="media-body">
                      <div class="media-heading" v-html="notify.content"></div>
                      <p class="m-0">
                          <small v-html="timePretty(notify.created_at)"></small>
                      </p>
                    </div>
                </div>
              </a>
          </li>
          <li>
              <a href="/notification/all" class="list-group-item text-right">
                  <small class="font-600">Xem tất cả</small>
              </a>
          </li>
      </ul>
  </li>
</template>
<script>
    export default {
        data() {
            return {
                options:{
                    position: 'right',size: "5px", color: '#98a6ad',height: '230px',wheelStep: 10
                },
            }
        },
        created() {
          const that = this;
          axios.get('/admin/api/notification?page=1').then(res => {
            that.$root.notifications = res.data;
            that.$root.unread = res.data.unread
          });
        },
        methods: {
          getRealtimeData() {
            const that = this;
            socket.on('notify', res => {
              const data = JSON.parse(res);
              that.$root.notifications = data
              const first = data.items[0];
              toastr.info(first['content'], first.type === 'video' ? 'Video' : 'Bình luận')
            });
          },
        },
        mounted() {
          this.getRealtimeData();
        }
    }
</script> 
<style>
  div.media-heading {
    font-weight: 400 !important;
    font-size: 14px !important;
  }
</style>