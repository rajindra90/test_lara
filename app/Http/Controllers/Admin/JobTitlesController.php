<?php

namespace App\Http\Controllers\Admin;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\JobTitleCreateRequest;
use App\Http\Requests\JobTitleUpdateRequest;
use App\Repositories\Contracts\Admin\JobTitleRepository;


class JobTitlesController extends Controller
{

    /**
     * @var JobTitleRepository
     */
    protected $repository;

    /**
     * @var JobTitleValidator
     */
    protected $validator;

    public function __construct(JobTitleRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobTitles = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $jobTitles,
            ]);
        }

        return view('jobTitles.index', compact('jobTitles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  JobTitleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(JobTitleCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $jobTitle = $this->repository->create($request->all());

            $response = [
                'message' => 'JobTitle created.',
                'data'    => $jobTitle->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobTitle = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $jobTitle,
            ]);
        }

        return view('jobTitles.show', compact('jobTitle'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $jobTitle = $this->repository->find($id);

        return view('jobTitles.edit', compact('jobTitle'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  JobTitleUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(JobTitleUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $jobTitle = $this->repository->update($id, $request->all());

            $response = [
                'message' => 'JobTitle updated.',
                'data'    => $jobTitle->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'JobTitle deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'JobTitle deleted.');
    }
}
