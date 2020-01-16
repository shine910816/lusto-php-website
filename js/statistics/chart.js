echarts.init(document.getElementById('amount_chart')).setOption({
    title: {
        text: '会员卡销售额'
    },
    color: [
        "#A42240"
    ],
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: 'shadow'
        }
    },
    xAxis: {
        data: date_data
    },
    yAxis: {},
    series: [{
        name: '会员卡销售额',
        type: 'bar',
        data: amount_data
    }]
});
echarts.init(document.getElementById('times_chart')).setOption({
    title: {
        text: '会员洗车次数'
    },
    color: [
        "#4C9C17"
    ],
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: 'shadow'
        }
    },
    xAxis: {
        data: date_data
    },
    yAxis: {},
    series: [{
        name: '会员洗车次数',
        type: 'bar',
        data: times_data
    }]
});
echarts.init(document.getElementById('predict_chart')).setOption({
    title: {
        text: '预估销售额'
    },
    color: [
        "#3399FF"
    ],
    tooltip: {
        trigger: "axis",
        axisPointer: {
            type: 'shadow'
        }
    },
    xAxis: {
        data: date_data
    },
    yAxis: {},
    series: [{
        name: '预估销售额',
        type: 'bar',
        data: predict_data
    }]
});
