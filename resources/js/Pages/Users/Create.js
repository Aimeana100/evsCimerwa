import LoadingButton from "@/AppComponents/LoadingButton";
import SelectInput from "@/AppComponents/SelectInput";
import TextInput from "@/AppComponents/TextInput";
import Input from "@material-tailwind/react/Input";
import Layout from "@/Layouts/Layout";
import { InertiaLink, useForm } from "@inertiajs/inertia-react";
import React from "react";

const Create = () => {
    const { data, setData, errors, post, processing } = useForm({
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        owner: "0",
        photo: "",
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route("users.store"));
    }
    return (
        <div>
            <div className="md:ml-64 flex align-middle flex-col">
                <div>
                    <h1 className="mb-8 text-3xl font-bold self-start">
                        <InertiaLink
                            href={route("users")}
                            className="text-indigo-600 hover:text-indigo-700"
                        >
                            Users
                        </InertiaLink>
                        <span className="font-medium text-indigo-600"> /</span>{" "}
                        Create
                    </h1>
                </div>

                <div className="max-w-5xl overflow-hidden flex justify-center align-middle lg:pl-10 rounded shadow">
                    <form
                        name="createForm lg:w-3/6 md:max-w-lg"
                        onSubmit={handleSubmit}
                    >
                        <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                            <TextInput
                                className="w-full pb-8 pr-6 lg:w-1/2  "
                                label="Full names"
                                name="first_name"
                                errors={errors.first_name}
                                value={data.first_name}
                                onChange={(e) =>
                                    setData("first_name", e.target.value)
                                }
                            />

                            <TextInput
                                className="w-full pb-8 pr-6 lg:w-1/2"
                                label="Last Name"
                                name="last_name"
                                errors={errors.last_name}
                                value={data.last_name}
                                onChange={(e) =>
                                    setData("last_name", e.target.value)
                                }
                            />
                            <TextInput
                                className="w-full pb-8 pr-6 lg:w-1/2"
                                label="Email"
                                name="email"
                                type="email"
                                errors={errors.email}
                                value={data.email}
                                onChange={(e) =>
                                    setData("email", e.target.value)
                                }
                            />
                            <TextInput
                                className="w-full pb-8 pr-6 lg:w-1/2"
                                label="Password"
                                name="password"
                                type="password"
                                errors={errors.password}
                                value={data.password}
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                            />
                            <SelectInput
                                className="w-full pb-8 pr-6 lg:w-1/2"
                                label="Owner"
                                name="owner"
                                errors={errors.owner}
                                value={data.owner}
                                onChange={(e) =>
                                    setData("owner", e.target.value)
                                }
                            >
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </SelectInput>
                            {/* 
                            <FileInput
                                className="w-full pb-8 pr-6 lg:w-1/2"
                                label="Photo"
                                name="photo"
                                accept="image/*"
                                errors={errors.photo}
                                value={data.photo}
                                onChange={(photo) => setData("photo", photo)}
                            />
                             */}
                        </div>
                        <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
                            <LoadingButton
                                loading={processing}
                                type="submit"
                                className="btn-indigo"
                            >
                                Create User
                            </LoadingButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

Create.layout = (page) => <Layout title={"Create a User"} children={page} />;

export default Create;
