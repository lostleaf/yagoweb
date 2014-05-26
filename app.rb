require 'sinatra/base'
class App < Sinatra::Base
    get "/" do
        @results = nil
        @headers = nil
        @descriptions = Model.descriptions
        erb :index
    end

    get "/:type/:arg" do |type, arg|
    	@headers, @results = Model.query type, arg
        @descriptions = Model.descriptions
        @type = type
        @arg = arg
        erb :index
    end
end
