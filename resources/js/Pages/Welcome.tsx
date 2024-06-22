import {Head, Link, useForm} from '@inertiajs/react';
import {PageProps, Settings} from '@/types';
import {ChangeEvent, FormEventHandler} from "react";
import toast from "react-hot-toast";
import DefaultLayout from "@/Layouts/DefaultLayout";

type WelcomeProps = {
  log: string
}

export default function Welcome({settings, log}: PageProps<WelcomeProps>) {
  const {data, setData, post} = useForm<Settings>(settings);
  const save: FormEventHandler = (e) => {
    e.preventDefault();
    const toast_id = toast.loading('Загрузка...');
    post('/api/save', {
      preserveScroll: true,
      only: ['log'],
      onSuccess: () => { toast.success('Сохранено') },
      onError: (params) => { toast.error('Ошибка'); console.error(params) },
      onFinish: () => toast.dismiss(toast_id),
    });
  }
  const handleForm = (name: (keyof FormData | ChangeEvent<HTMLInputElement|HTMLSelectElement>), value: any = null) => {
    if(typeof name == "string")
      setData({...data, [name]: value});
    else
      setData({...data, [name.target.name]: name.target.value})
  }
  return (
    <DefaultLayout>
      <Head title="Welcome"/>
      <div className="container pt-10">
        <form onSubmit={save} className="mb-2">
          <div className="text-2xl mb-2 font-semibold">Настройки</div>
          <div className="flex gap-x-10">
            <div>
              <div className="text-lg mb-0.5">Файл лога</div>
              <div className="flex gap-x-1">
                <input type="text" name="path" className="px-2 py-1" value={data.path} onChange={handleForm} placeholder="Путь до лога"/>
                <div className="self-end font-bold">.</div>
                <select name="format" onChange={handleForm} value={data.format}>
                  <option value="txt">TXT</option>
                  <option value="xml">XML</option>
                </select>
              </div>
            </div>
          </div>

          <button type="submit" className="rounded bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 mt-3">Сохранить</button>
        </form>
      </div>
      <div className="container">
        <Link href={route('welcome')} only={['log']} className="rounded bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 mt-3 inline-block">Обновить лог</Link>
        <div className="border p-2 whitespace-pre-wrap mt-5 h-[500px] overflow-auto">
          {log}
        </div>
      </div>
    </DefaultLayout>
  );
}
