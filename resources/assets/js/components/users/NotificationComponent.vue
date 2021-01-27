<template>
   <!-- Right Sidebar -->
  <div class="col-lg-9 col-md-8">
    <div class="panel panel-default m-t-20">
      <div class="panel-body p-0">
        <div class="table-responsive">
            <table class="table table-hover notifies m-0">
              <tbody>
                <tr v-for="(notify, index) in $root.notifications.items" :key="index" :class="notify.pivot.is_read ? '' : 'unread'" @click="read($event.target, notify.pivot.id, index, 'tr', 'unread')">
                  <td class="order">
                    <span class="m-r-15" v-html="getOrderNumber(currentPage, index)"></span>
                  </td>
                  
                  <td v-html="notify.type === 'video' ? 'Video' : 'Bình luận'"></td>
                  
                  <td class="hidden-xs" v-html="notify.content">
                  </td>
                  <td style="width: 20px;">
                    <i class="fa fa-video-camera text-danger" v-if="notify.type === 'video'"></i>
                    <i class="fa fa-comment text-default" v-else></i>
                  </td>
                  <td class="text-right" v-html="timePretty(notify.created_at, 2)">
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
      </div> <!-- panel body -->
    </div> <!-- panel -->
    
    <div class="row">
      <!-- <div class="col-xs-7" v-html="str">
      </div> -->
      <div class="col-xs-5">
          <div class="btn-group pull-right">
            <button type="button" class="btn btn-default waves-effect" :disabled="currentPage == 1" @click="fetchData(currentPage--)"><i class="fa fa-chevron-left"></i></button>
            <button type="button" class="btn btn-default waves-effect" :disabled="currentPage == pages" @click="fetchData(currentPage++)"><i class="fa fa-chevron-right"></i></button>
          </div>
      </div>
    </div>
  </div> <!-- end Col-9 -->
</template>
<script>
export default {
  data() {
    return {
      currentPage: 1,
      pages: 1,
      str: '',
      notifications: {}
    }
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      const that = this;
      axios.get(`/admin/api/notification?page=${that.currentPage}`).then(res => {
        that.currentPage = res.data.currentPage;
        that.$root.notifications = res.data
        const total = res.data.total
        that.pages = res.data.pages
        const start = (that.currentPage - 1)*10 +1
        let end = (that.currentPage - 1)*10 + Object.keys(res.data.items).length
        if(that.currentPage !== that.pages) end = that.currentPage * 10
        that.str = `Hiển thị ${start} - ${end} trên tổng số ${total}`
      });
    },
    getRealtimeData() {
      const that = this;
      socket.on('notify', res => {
        const data = JSON.parse(res);
        that.$root.notifications = data
        const first = data.items[0];
      });
    },
  },
  mounted() {
    this.getRealtimeData();
  }
}
</script>
<style>
.mails td:last-of-type {
  width:130px
}
.notifies tr {
  cursor: pointer;
}
</style>