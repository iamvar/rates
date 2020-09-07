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
    findLatest() {
        return axios.get("/api/actual");
    },
    retrieve() {
        return axios.get("/api/retrieve");
    },
};