<answer :answer="{{ $answer }}" inline-template>
	<div class="media post answer-wrapper">
		<div class="row">

			<vote-buttons :model="{{ $answer }}" name="answer"></vote-buttons>
	
			<div class="media-body">
				<form v-if="editing" class="answer-form-size-quick-fix" @submit.prevent="update">
					<div class="form-group">
						<textarea required v-model="body" rows="10" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit" :disabled="isInvalid">{{ __('Update') }}</button>
						<button class="btn btn-outline-secondary" type="button" @click.prevent="cancel">{{ __('Cancel') }}</button>
					</div>
				</form>
				<div v-else>

					<div v-html="bodyHtml"></div>
	
	
					<footer class="row answer-infos">
						<div class="col-4 owner-controls">
							<div class="ml-auto">
								@can('update', $answer)
								<a @click.prevent="edit" href="#" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
								@endcan
			
								@can('delete', $answer)
									<button type="button" class="btn btn-sm btn-outline-danger" @click.prevent="destroy">{{ __('Delete') }}</button>
								@endcan 
							</div>								
						</div>
						<div class="col-3"></div>
						<div class="col-5">
							<user-info :model="{{ $answer }}" label="{{ __('answered') }}"></user-info>
						</div>
					</footer>					

				</div>
			</div>
	
	
		</div>
	</div>
</answer>	

