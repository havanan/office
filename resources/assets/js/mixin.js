// define a mixin object
export const myMixin = {
  data() {
    return {
      validates: [],
      notifications: {},
      unread: 0
    }
  },
  methods: {
    currencyFormat(num) {
      let result = 0;
      if (num){
          result = '¥' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
      }
      return result;
    },
      numberFormat(num) {
        return new Intl.NumberFormat().format(num)
      },
    getValidation: function (column) {
      if(Object.keys(this.validates).length > 0) return this.validates[column] !== undefined ? this.validates[column][0] : '';
      return '';
    },
    setValidation(values) {
      this.validates = Object.keys(values).length > 0 ? values.response.data.errors : [];
    },
    getOrderNumber(currentPage, index, perPage = 10) {
      return (currentPage - 1) * perPage + index + 1
    },
    timePretty(datetime, type = 1) {
      if(type == 1)
        return moment(datetime).fromNow()
      if(moment().diff(datetime, 'years') > 0) {
        return moment(datetime).format('ll')
      }
      if(moment().diff(datetime, 'days') > 0) {
        return moment(datetime).format('D MMMM')
      }
      return moment(datetime).format('LT')
    },
    read(el, id, index, parent = 'a.wgd-notify', active = 'bg-gray') {
      const that = this;
      const status = that.$root.notifications.items[index].pivot.is_read;
      axios.get(`/notification/read?n=${id}&s=${status ? 0 : 1}`).then(res => {
        if(res.code === 200) {
          const noti = $(el).closest(parent).eq(0);
          that.$root.notifications.items[index].pivot.is_read = !status;
          if(!status) {
            $(noti).removeClass(active)
            that.$root.unread--;
          }  else {
            $(noti).addClass(active)
            that.$root.unread++;
          }


        }
      });
    },
    htmlDecode : function(html){
      var div = document.createElement("div");
      div.innerHTML = html;
      return div.innerText
    },
    getNewsStatus(value){
      switch (value) {
           case 1:
               value = '<i class="fa fa-circle text-success mr-2"></i> Hiển thị';
               break;
           default: value = '<i class="fa fa-circle text-danger mr-2"></i> Ẩn';
       }
       return value;
  },
   getNewsAuthor:function(value){
       let result = '';

       if (value && value.fullname){

           result = '<a href="'+value.id+'" target="_blank">'+value.fullname+'</a>';

       }
       return result;
   },
   getNewsTags:function(value){

    let group = [];

    if (value && value.length > 0){

        for (let i = 0;i < value.length; i++){

            if (value[i].tag_info){

                group.push(value[i].tag_info);

            }
        }
    }

    return this.arrayToStringNews(group,'tag');
},
getNewsCategories:function(value){

    let group = [];

    if (value && value.length > 0){

        for (let i = 0;i < value.length; i++){

            if (value[i].category_info){

                group.push(value[i].category_info);

            }
        }
    }

    return this.arrayToStringNews(group,'cat');
},
arrayToStringNews:function(array,type){
  let result = '';

  let icon = 'fa-tag';

  if(type === 'cat'){

      icon = 'fa-folder-open-o';

  }
  if (array.length > 0){

     for (let i = 0;i < array.length; i++){

         result += '<a class="m-r-5"><i class="fa '+icon+' m-r-5"></i>'+array[i].name+'</a>';

     }

  }
  return result;

},
getImageFormPreview : function () {
    const imagePath = $('#thumbnail').val();
    if (imagePath){
        this.imagePath =  imagePath;
        this.formData.images = imagePath;
    }
},
removeImageForm:function(){

    this.formData.images = '';

    this.imagePath = '/storage/admin/images/no_image.png';

  },
  }
}
