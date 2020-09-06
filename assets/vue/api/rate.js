import axios from "axios";

export default {
    create(message) {
        return axios.post("/api/create", {
            message: message
        });
    },
    findAll() {
        return axios.get("/api/rates");
    },
    retrieve() {
        return axios.get("/api/retrieve");
    }
};