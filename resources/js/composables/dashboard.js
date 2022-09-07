import { ref, reactive } from "vue";
import axios from "axios";

export default function useDashboard() {
    const dashboards = ref([]);
    const dashboard = ref([]);
    const errors_dash = ref([]);

    const getdashboard_datas = async () => {
        let response = await axios.get("/dashboard/get");
        dashboards.value = response.data.data;
    };

    return {
        dashboards,
        dashboard,
        errors_dash,
        getdashboard_datas,
    };
}
